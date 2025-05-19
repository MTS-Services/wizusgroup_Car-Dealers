<?php

namespace Database\Seeders;

use App\Models\ProductInfoCategoryTypeFeature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductInfoCategoryTypeFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         ProductInfoCategoryTypeFeature::create([
            'product_info_cat_id' => 1, // Specifications
            'product_info_cat_type_id' => 1, // Dimensions
            'name' => 'Height',
            'slug' => 'height',
        ]);

        ProductInfoCategoryTypeFeature::create([
            'product_info_cat_id' => 1, // Specifications
            'product_info_cat_type_id' => 1, // Dimensions
            'name' => 'Width',
            'slug' => 'width',
        ]);

        ProductInfoCategoryTypeFeature::create([
            'product_info_cat_id' => 1, // Specifications
            'product_info_cat_type_id' => 2, // Weight
            'name' => 'Net Weight',
            'slug' => 'net-weight',
        ]);

        ProductInfoCategoryTypeFeature::create([
            'product_info_cat_id' => 2, // Warranty Information
            'product_info_cat_type_id' => 3, // Warranty Period
            'name' => 'Years of Warranty',
            'slug' => 'years-of-warranty',
        ]);

        ProductInfoCategoryTypeFeature::create([
            'product_info_cat_id' => 4, // Technical Details
            'product_info_cat_type_id' => 5, // Processor Type
            'name' => 'Processor Brand',
            'slug' => 'processor-brand',
        ]);
    }
}
