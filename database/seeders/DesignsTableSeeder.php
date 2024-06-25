<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('designs')->insert([
            [
                "user_id" => 1,
                'name' => 'Wooden Modern Modular Cupboard, Base Mounted',
                'category_id' => 10,
                'category_key_id' => 1,
                'type' => 'Exterior', 
                'image_url' => '/images/designs/modular-kitchen-cupboard.webp', 
                'unit_id'=> 1
            ],
            [
                "user_id" => 1,
                'name' => 'Modern Wooden PVC Cupboard',
                'category_id' => 10,
                'category_key_id' => 1,
                'type' => 'Exterior', 
                'image_url' => '/images/designs/pvc-kitchen-cupboard.webp', 
                'unit_id'=> 1
            ],
            [
                "user_id" => 1,
                'name' => 'Garden Bench',
                'category_id' => 46,
                'category_key_id' => 31,
                'type' => 'Exterior', 
                'image_url' => '/images/designs/garden-bench-1.webp', 
                'unit_id'=> 1
            ],
            [
                "user_id" => 1,
                'name' => 'Wooden 3 Doors PVC Loft Cover, With Locker',
                'category_id' => 22,
                'category_key_id' => 3,
                'type' => 'Exterior', 
                'image_url' => '/images/designs/bedroom-loft-door.webp', 
                'unit_id'=> 1
            ],
            [
                "user_id" => 1,
                'name' => 'Ci Garden Bench',
                'category_id' => 46,
                'category_key_id' => 31,
                'type' => 'Exterior', 
                'image_url' => '/images/designs/garden-bench.webp', 
                'unit_id'=> 1
            ],
            [
                "user_id" => 1,
                'name' => 'Wooden 2 Doors Pvc Loft Covering, With Locker',
                'category_id' => 22,
                'category_key_id' => 3,
                'type' => 'Exterior', 
                'image_url' => '/images/designs/pvc-l-shape-loft-covering.webp', 
                'unit_id'=> 1
            ],
            [
                "user_id" => 1,
                'name' => 'Cast Iron Wood Park Bench',
                'category_id' => 46,
                'category_key_id' => 31,
                'type' => 'Exterior', 
                'image_url' => '/images/designs/brown-garden-bench.webp', 
                'unit_id'=> 1
            ],
            [
                "user_id" => 1,
                'name' => 'Aluminum Cupboards',
                'category_id' => 10,
                'category_key_id' => 1,
                'type' => 'Exterior', 
                'image_url' => '/images/designs/aluminium-kitchen-cupboards.webp', 
                'unit_id'=> 1
            ],
        ]);
    }
}
