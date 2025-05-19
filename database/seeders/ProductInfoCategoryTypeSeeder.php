<?php

namespace Database\Seeders;

use App\Models\ProductInfoCategoryType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductInfoCategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductInfoCategoryType::create([
            'product_info_cat_id' => 2, // Specifications
            'name' => 'Front',
            'slug' => 'front',
        ]);
        ProductInfoCategoryType::create([
            'product_info_cat_id' => 2,
            'name' => 'Side',
            'slug' => 'side',
        ]);
        ProductInfoCategoryType::create([
            'product_info_cat_id' => 2,
            'name' => 'Rear',
            'slug' => 'rear',
        ]);
        ProductInfoCategoryType::create([
            'product_info_cat_id' => 2,
            'name' => 'Suspension',
            'slug' => 'suspension',
        ]);
    }
}
