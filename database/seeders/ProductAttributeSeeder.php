<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductAttribute::create([
            'name' => 'Engine Type',
        ]);

        ProductAttribute::create([
            'name' => 'Transmission',
        ]);

        ProductAttribute::create([
            'name' => 'Fuel Type',
        ]);

        ProductAttribute::create([
            'name' => 'Year of Manufacture',
        ]);
    }
}
