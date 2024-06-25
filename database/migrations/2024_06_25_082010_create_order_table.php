<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->string('level');
            $table->string('type')->nullable();
            $table->string('context')->nullable();
            $table->string('source')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->text('extra_info')->nullable();
            $table->timestamps();
        });

        Schema::create('quantity_units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('e.g., SQ.FT, EACH');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('dimensions')->nullable();
            $table->enum('type', ['Interior', 'Exterior', 'Both'])->default('Interior');
            $table->unsignedBigInteger('unit_id')->index();
            $table->decimal('rate_per', 10, 2);
            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('quantity_units')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('parent_id')->index()->nullable();
            $table->enum('type', ['Interior', 'Exterior', 'Both'])->default('Interior');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('categories')->cascadeOnDelete();
        });

    
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->enum('type', ['Interior', 'Exterior', 'Both'])->default('Interior');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('customer_id')->index();
            $table->enum('status', ['ongoing', 'follow-up', 'completed', 'cancelled'])->default('ongoing');
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('customer_id')->references('id')->on('customers');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('design_id')->index();
            $table->decimal('quantity', 10, 2);
            $table->decimal('rate_per', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('discount_percentage', 5, 2)->default(0.00);
            $table->decimal('total', 10, 2);
            $table->decimal('sub_total', 10, 2);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('invoice_number')->unique();
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('discount_percentage', 5, 2)->default(0.00);
            $table->decimal('sub_total_amount', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('advance_pay_amount', 10, 2);
            $table->decimal('balance_amount', 10, 2);
            $table->enum('payment_status', ['pending', 'paid', 'partially_paid', 'late', 'overdue'])->default('pending');
            $table->enum('payment_method', ['cash', 'credit_card', 'bank_transfer', 'paypal', 'UPI', 'other'])->nullable();
            $table->text('payment_history')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->timestamp('created_date')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('customer_id')->references('id')->on('customers');
        });

        Schema::create('category_keys', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); 
            $table->string('general_key')->nullable(); 
            $table->timestamps();
        });

        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('category_key_id')->index();
            $table->string('image_url');
            $table->enum('type', ['Interior', 'Exterior', 'Both'])->default('Interior');
            $table->unsignedBigInteger('unit_id')->index();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('category_key_id')->references('id')->on('category_keys');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designs');
        Schema::dropIfExists('category_keys');
        Schema::dropIfExists('logs');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('quantity_units');
    }
};
