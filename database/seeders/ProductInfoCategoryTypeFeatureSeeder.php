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
            'product_info_cat_id' => 2,
            'product_info_cat_type_id' => 1,
            'name' => 'Front Bumper',
            'slug' => 'front-bumper',
        ]);
        ProductInfoCategoryTypeFeature::create([
            'product_info_cat_id' => 2,
            'product_info_cat_type_id' => 1,
            'name' => 'Bonnet',
            'slug' => 'bonnet',
        ]);
        ProductInfoCategoryTypeFeature::create([
            'product_info_cat_id' => 2,
            'product_info_cat_type_id' => 1,
            'name' => 'Left Front Fender',
            'slug' => 'left-front-fender',
        ]);
    }
}
