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
            'product_info_cat_id' => 1, // Specifications
            'name' => 'Dimensions',
            'slug' => 'dimensions',
        ]);

        ProductInfoCategoryType::create([
            'product_info_cat_id' => 1, // Specifications
            'name' => 'Weight',
            'slug' => 'weight',
        ]);

        ProductInfoCategoryType::create([
            'product_info_cat_id' => 2, // Warranty Information
            'name' => 'Warranty Period',
            'slug' => 'warranty-period',
        ]);

        ProductInfoCategoryType::create([
            'product_info_cat_id' => 3, // User Guide
            'name' => 'Setup Instructions',
            'slug' => 'setup-instructions',
        ]);

        ProductInfoCategoryType::create([
            'product_info_cat_id' => 4, // Technical Details
            'name' => 'Processor Type',
            'slug' => 'processor-type',
        ]);
    }
}
