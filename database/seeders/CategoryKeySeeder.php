<?php

namespace Database\Seeders;

use App\Models\CategoryKey;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryKeys = [
            ['key' => 'Cupboard'],
            ['key' => 'Wall Unit'],
            ['key' => 'Loft Door', 'general_key' => 'Door'],
            ['key' => 'Countertop'],
            ['key' => 'Backsplash'],
            ['key' => 'Cabinet'],
            ['key' => 'TV Unit'],
            ['key' => 'Shelves'],
            ['key' => 'Sofa'],
            ['key' => 'Coffee Table', 'general_key' => 'Table'],
            ['key' => 'Wardrobe'],
            ['key' => 'Study Table', 'general_key' => 'Table'],
            ['key' => 'Bed Frame'],
            ['key' => 'Nightstand'],
            ['key' => 'Vanity Unit'],
            ['key' => 'Mirror Frame'],
            ['key' => 'Shower Enclosure'],
            ['key' => 'Sink Cabinet'],
            ['key' => 'Table'],
            ['key' => 'Chair'],
            ['key' => 'Sideboard'],
            ['key' => 'Hutch'],
            ['key' => 'Bar Cabinet'],
            ['key' => 'Desk'],
            ['key' => 'Bookcase'],
            ['key' => 'Workbench'],
            ['key' => 'Storage Cabinet'],
            ['key' => 'Tool Rack'],
            ['key' => 'Door'],
            ['key' => 'Shed'],
            ['key' => 'Bench'],
            ['key' => 'Fence'],
            ['key' => 'Pergola'],
            ['key' => 'Gazebo'],
            ['key' => 'Railing'],
            ['key' => 'Furniture'],
            ['key' => 'Planter'],
            ['key' => 'Awning'],
            ['key' => 'Decking'],
        ];

        foreach ($categoryKeys as $key) {
            CategoryKey::create($key);
        }
    }
}
