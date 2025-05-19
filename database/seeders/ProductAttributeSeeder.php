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
            'name' => 'Color',
        ]);

        ProductAttribute::create([
            'name' => 'Size',
        ]);

        ProductAttribute::create([
            'name' => 'Material',
        ]);

        ProductAttribute::create([
            'name' => 'Brand',
        ]);

        ProductAttribute::create([
            'name' => 'Model Number',
        ]);
    }
}
