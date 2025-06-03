<?php

namespace Database\Seeders;

use App\Models\ProductInfoCategoryType;
use Illuminate\Database\Seeder;

class ProductInfoCategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductInfoCategoryType::create([
            'id' => 1,
            'sort_order' => 0,
            'product_info_cat_id' => 2,
            'name' => 'Front',
            'slug' => 'front',
            'status' => 1,
            'created_at' => '2025-06-03 04:46:11',
            'updated_at' => '2025-06-03 04:46:11',
        ]);

        ProductInfoCategoryType::create([
            'id' => 2,
            'sort_order' => 0,
            'product_info_cat_id' => 2,
            'name' => 'Side',
            'slug' => 'side',
            'status' => 1,
            'created_at' => '2025-06-03 04:46:11',
            'updated_at' => '2025-06-03 04:46:11',
        ]);

        ProductInfoCategoryType::create([
            'id' => 3,
            'sort_order' => 0,
            'product_info_cat_id' => 2,
            'name' => 'Rear',
            'slug' => 'rear',
            'status' => 1,
            'created_at' => '2025-06-03 04:46:11',
            'updated_at' => '2025-06-03 04:46:11',
        ]);

        ProductInfoCategoryType::create([
            'id' => 4,
            'sort_order' => 0,
            'product_info_cat_id' => 2,
            'name' => 'Suspension',
            'slug' => 'suspension',
            'status' => 1,
            'created_at' => '2025-06-03 04:46:11',
            'updated_at' => '2025-06-03 04:46:11',
        ]);

        ProductInfoCategoryType::create([
            'id' => 5,
            'sort_order' => 0,
            'product_info_cat_id' => 1,
            'name' => 'Situation of Damage',
            'slug' => 'situation-of-damage',
            'status' => 1,
            'created_at' => '2025-06-03 08:01:35',
            'updated_at' => '2025-06-03 08:01:35',
            'created_by' => 1,
        ]);

        ProductInfoCategoryType::create([
            'id' => 6,
            'sort_order' => 0,
            'product_info_cat_id' => 1,
            'name' => 'Engine Room',
            'slug' => 'engine-room',
            'status' => 1,
            'created_at' => '2025-06-03 08:02:00',
            'updated_at' => '2025-06-03 08:02:00',
            'created_by' => 1,
        ]);

        ProductInfoCategoryType::create([
            'id' => 7,
            'sort_order' => 0,
            'product_info_cat_id' => 3,
            'name' => 'Air-bag',
            'slug' => 'air-bag',
            'status' => 1,
            'created_at' => '2025-06-03 08:02:59',
            'updated_at' => '2025-06-03 08:02:59',
            'created_by' => 1,
        ]);

        ProductInfoCategoryType::create([
            'id' => 8,
            'sort_order' => 0,
            'product_info_cat_id' => 3,
            'name' => 'Equipment',
            'slug' => 'equipment',
            'status' => 1,
            'created_at' => '2025-06-03 08:04:41',
            'updated_at' => '2025-06-03 08:04:41',
            'created_by' => 1,
        ]);
    }
}
