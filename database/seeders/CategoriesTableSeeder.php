<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Kitchen', 'type' => 'Interior'],
            ['name' => 'Living Room', 'type' => 'Interior'],
            ['name' => 'Bedroom', 'type' => 'Interior'],
            ['name' => 'Bathroom', 'type' => 'Interior'],
            ['name' => 'Dining Room', 'type' => 'Interior'],
            ['name' => 'Home Office', 'type' => 'Interior'],
            ['name' => 'Garage', 'type' => 'Exterior'],
            ['name' => 'Garden', 'type' => 'Exterior'],
            ['name' => 'Balcony', 'type' => 'Both'],
        ]);

        // Subcategories with parent_id
        DB::table('categories')->insert([

            ['name' => 'Kitchen Cupboard', 'parent_id' => 1, 'type' => 'Interior'],
            ['name' => 'Kitchen Wall Unit', 'parent_id' => 1, 'type' => 'Interior'],
            ['name' => 'Kitchen Loft Door', 'parent_id' => 1, 'type' => 'Interior'],
            ['name' => 'Kitchen Countertop', 'parent_id' => 1, 'type' => 'Interior'],
            ['name' => 'Kitchen Backsplash', 'parent_id' => 1, 'type' => 'Interior'],

            ['name' => 'Living Room Cabinet', 'parent_id' => 2, 'type' => 'Interior'],
            ['name' => 'Living Room TV Unit', 'parent_id' => 2, 'type' => 'Interior'],
            ['name' => 'Living Room Shelves', 'parent_id' => 2, 'type' => 'Interior'],
            ['name' => 'Living Room Sofa', 'parent_id' => 2, 'type' => 'Interior'],
            ['name' => 'Living Room Coffee Table', 'parent_id' => 2, 'type' => 'Interior'],

            ['name' => 'Bedroom Wardrobe', 'parent_id' => 3, 'type' => 'Interior'],
            ['name' => 'Bedroom Study Table', 'parent_id' => 3, 'type' => 'Interior'],
            ['name' => 'Bedroom Loft Door', 'parent_id' => 3, 'type' => 'Interior'],
            ['name' => 'Bedroom Bed Frame', 'parent_id' => 3, 'type' => 'Interior'],
            ['name' => 'Bedroom Nightstand', 'parent_id' => 3, 'type' => 'Interior'],

            ['name' => 'Bathroom Vanity Unit', 'parent_id' => 4, 'type' => 'Interior'],
            ['name' => 'Bathroom Wall Cabinet', 'parent_id' => 4, 'type' => 'Interior'],
            ['name' => 'Bathroom Mirror Frame', 'parent_id' => 4, 'type' => 'Interior'],
            ['name' => 'Bathroom Shower Enclosure', 'parent_id' => 4, 'type' => 'Interior'],
            ['name' => 'Bathroom Sink Cabinet', 'parent_id' => 4, 'type' => 'Interior'],

            ['name' => 'Dining Room Table', 'parent_id' => 5, 'type' => 'Interior'],
            ['name' => 'Dining Room Chairs', 'parent_id' => 5, 'type' => 'Interior'],
            ['name' => 'Dining Room Sideboard', 'parent_id' => 5, 'type' => 'Interior'],
            ['name' => 'Dining Room Hutch', 'parent_id' => 5, 'type' => 'Interior'],
            ['name' => 'Dining Room Bar Cabinet', 'parent_id' => 5, 'type' => 'Interior'],

            ['name' => 'Office Desk', 'parent_id' => 6, 'type' => 'Interior'],
            ['name' => 'Office Chair', 'parent_id' => 6, 'type' => 'Interior'],
            ['name' => 'Office Shelves', 'parent_id' => 6, 'type' => 'Interior'],
            ['name' => 'Office Cabinet', 'parent_id' => 6, 'type' => 'Interior'],
            ['name' => 'Office Bookcase', 'parent_id' => 6, 'type' => 'Interior'],

            ['name' => 'Garage Shelves', 'parent_id' => 7, 'type' => 'Exterior'],
            ['name' => 'Garage Workbench', 'parent_id' => 7, 'type' => 'Exterior'],
            ['name' => 'Garage Storage Cabinet', 'parent_id' => 7, 'type' => 'Exterior'],
            ['name' => 'Garage Tool Rack', 'parent_id' => 7, 'type' => 'Exterior'],
            ['name' => 'Garage Door', 'parent_id' => 7, 'type' => 'Exterior'],

            ['name' => 'Garden Shed', 'parent_id' => 8, 'type' => 'Exterior'],
            ['name' => 'Garden Bench', 'parent_id' => 8, 'type' => 'Exterior'],
            ['name' => 'Garden Fence', 'parent_id' => 8, 'type' => 'Exterior'],
            ['name' => 'Garden Pergola', 'parent_id' => 8, 'type' => 'Exterior'],
            ['name' => 'Garden Gazebo', 'parent_id' => 8, 'type' => 'Exterior'],

            ['name' => 'Balcony Railing', 'parent_id' => 9, 'type' => 'Both'],
            ['name' => 'Balcony Furniture', 'parent_id' => 9, 'type' => 'Both'],
            ['name' => 'Balcony Planter', 'parent_id' => 9, 'type' => 'Both'],
            ['name' => 'Balcony Awning', 'parent_id' => 9, 'type' => 'Both'],
            ['name' => 'Balcony Decking', 'parent_id' => 9, 'type' => 'Both'],
        ]);
    }
}
