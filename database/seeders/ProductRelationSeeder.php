<?php

namespace Database\Seeders;

use App\Models\ProductRelation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         ProductRelation::create([
            'product_id' => 1,
            'brand_id' => 1, // John Deere
            'model_id' => 1, // 5055E
            'tax_class_id' => 1,
            'tax_rate_id' => 1,
            'company_id' => 1, // John Deere
            'category_id' => 1, // Agricultural Machinery
            'sub_category_id' => null,
            'sub_child_category_id' => null,
        ]);

        ProductRelation::create([
            'product_id' => 2,
            'brand_id' => 10, // Ford
            'model_id' => 11, // Mustang
            'tax_class_id' => 2,
            'tax_rate_id' => 2,
            'company_id' => 10, // Ford
            'category_id' => 2, // Construction Equipment
            'sub_category_id' => null,
            'sub_child_category_id' => null,
        ]);

        ProductRelation::create([
            'product_id' => 3,
            'brand_id' => 8, // Toyota
            'model_id' => 8, // Corolla
            'tax_class_id' => 1,
            'tax_rate_id' => 1,
            'company_id' => 8, // Toyota Motor Corporation
            'category_id' => 3, // Vehicles
            'sub_category_id' => null,
            'sub_child_category_id' => null,
        ]);

        ProductRelation::create([
            'product_id' => 4,
            'brand_id' => 3, // Massey Ferguson
            'model_id' => 3, // MF 241 DI
            'tax_class_id' => 1,
            'tax_rate_id' => 1,
            'company_id' => 3, // AGCO Corporation
            'category_id' => 1, // Agricultural Machinery
            'sub_category_id' => null,
            'sub_child_category_id' => null,
        ]);
    }
}
