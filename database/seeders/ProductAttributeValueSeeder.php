<?php

namespace Database\Seeders;

use App\Models\ProductAttributeValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            [
                'product_id' => 1,
                'product_attribute_id' => 1, // Engine Type
                'value' => '4-Cylinder Turbo Diesel',
            ],
            [
                'product_id' => 1,
                'product_attribute_id' => 2, // Transmission
                'value' => 'Manual 6-Speed',
            ],
            [
                'product_id' => 2,
                'product_attribute_id' => 3, // Fuel Type
                'value' => 'Diesel',
            ],
            [
                'product_id' => 2,
                'product_attribute_id' => 4, // Year of Manufacture
                'value' => '2022',
            ],
            [
                'product_id' => 3,
                'product_attribute_id' => 1, // Engine Type
                'value' => 'V6 Petrol Engine',
            ],
        ];

        foreach ($values as $value) {
            ProductAttributeValue::create($value);
        }
    }
}
