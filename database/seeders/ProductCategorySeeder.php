<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductCategory::create([
            'category_id' => 1,
            'sub_category_id' => 2,
            'sub_child_category_id' => 3,
            'product_id' => 1,
        ]);

        ProductCategory::create([
            'category_id' => 1,
            'sub_category_id' => 4,
            'product_id' => 2,
        ]);

        ProductCategory::create([
            'category_id' => 1,
            'sub_category_id' => 5,
            'product_id' => 3,
        ]);

        ProductCategory::create([
            'category_id' => 2,
            'sub_category_id' => 6,
            'sub_child_category_id' => 7,
            'product_id' => 4,
        ]);
    }
}
