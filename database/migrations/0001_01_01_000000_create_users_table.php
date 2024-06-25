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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->enum('role', ['manager'])->default('manager');
            $table->timestamps();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); 
            $table->string('state');
            $table->string('city');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::create('branch_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('branch_name');
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

        });

        Schema::create('schedule', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->timestamp('start');
            $table->timestamp('end')->nullable();
            $table->string('level')->nullable();
            $table->enum('status', ['scheduled', 'canceled'])->default('scheduled');
            $table->enum('visibility', ['public', 'private', 'admin', 'manager'])->default('private');
            $table->boolean('is_editable')->default(true);
            $table->unsignedBigInteger('updater_admin_or_manager_id')->nullable(); 
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('type');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->string('title')->nullable();
            $table->json('data')->nullable();
            $table->string('link')->nullable();
            $table->string('icon')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

        });

        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('reminder_time');
            $table->boolean('is_completed')->default(false);  
            $table->integer('priority')->nullable();          
            $table->string('category')->nullable();
            $table->string('repeat')->nullable();
            $table->text('notes')->nullable();
            $table->enum('visibility', ['public', 'private', 'admin', 'manager'])->default('private');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('permissions'); 
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('reminders');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('schedule');
        Schema::dropIfExists('branch_addresses');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('managers');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('users');
    }
};
