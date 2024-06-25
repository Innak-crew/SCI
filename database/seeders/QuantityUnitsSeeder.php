<?php

namespace Database\Seeders;

use App\Models\QuantityUnits;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuantityUnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'name' => 'SQ.FT',
                'description' => 'Square Feet'
            ],
            [
                'name' => 'SQ.M',
                'description' => 'Square Meters'
            ],
            [
                'name' => 'SQ.YD',
                'description' => 'Square Yards'
            ],
            [
                'name' => 'ACRES',
                'description' => 'Acres'
            ],
            [
                'name' => 'GAL',
                'description' => 'Gallons'
            ],
            [
                'name' => 'LIT',
                'description' => 'Liters'
            ],
            [
                'name' => 'CU.FT',
                'description' => 'Cubic Feet'
            ],
            [
                'name' => 'CU.M',
                'description' => 'Cubic Meters'
            ],
            [
                'name' => 'IN',
                'description' => 'Inches'
            ],
            [
                'name' => 'FT',
                'description' => 'Feet'
            ],
            [
                'name' => 'YD',
                'description' => 'Yards'
            ],
            [
                'name' => 'CM',
                'description' => 'Centimeters'
            ],
            [
                'name' => 'MM',
                'description' => 'Millimeters'
            ],
            [
                'name' => 'LB',
                'description' => 'Pounds'
            ],
            [
                'name' => 'KG',
                'description' => 'Kilograms'
            ],
            [
                'name' => 'G',
                'description' => 'Grams'
            ],
            [
                'name' => 'OZ',
                'description' => 'Ounces'
            ],
            [
                'name' => 'DOZ',
                'description' => 'Dozen'
            ],
            [
                'name' => 'EACH',
                'description' => 'Individual Unit'
            ],
            [
                'name' => 'CTN',
                'description' => 'Carton'
            ],
            [
                'name' => 'PKG',
                'description' => 'Package'
            ],
        ];

        foreach ($units as $unit) {
            QuantityUnits::create($unit);
        }
    }
}
