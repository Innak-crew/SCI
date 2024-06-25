<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                "user_id" => 1,
                'name' => 'CENTURY MDF SHEET',
                'type' => 'Interior', 
                'image_url' => '/images/products/20240613153556_century-mdf-prowud-dir-plywood.png', 
                'unit_id'=> 1,
                "rate_per" => 450.00
            ],
            [
                "user_id" => 1,
                'name' => 'WATER PROOF CENTURY PLYWOOD SHEET',
                'type' => 'Interior', 
                'image_url' => '/images/products/20240613160433_whatsapp-image-2023-10-10-at-15-01-30-0cedb26b.jpeg', 
                'unit_id'=> 1,
                "rate_per" => 1000.00
           ],
        ]);
    }
}
