<?php

namespace Database\Seeders;

use App\Models\ProductInfoCategory;
use Illuminate\Database\Seeder;

class ProductInfoCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductInfoCategory::create([
            'id' => 1,
            'sort_order' => 0,
            'name' => 'Main Damage',
            'slug' => 'main-damage',
            'status' => 1,
            'created_at' => '2025-06-03 04:46:11',
            'updated_at' => '2025-06-03 04:46:11',
        ]);

        ProductInfoCategory::create([
            'id' => 2,
            'sort_order' => 0,
            'name' => 'Exterior Damage',
            'slug' => 'exterior-damage',
            'status' => 1,
            'created_at' => '2025-06-03 04:46:11',
            'updated_at' => '2025-06-03 04:46:11',
        ]);

        ProductInfoCategory::create([
            'id' => 3,
            'sort_order' => 0,
            'name' => 'Air Bag Equipment',
            'slug' => 'air-bag-equipment',
            'status' => 1,
            'created_at' => '2025-06-03 04:46:11',
            'updated_at' => '2025-06-03 04:46:11',
        ]);

        ProductInfoCategory::create([
            'id' => 4,
            'sort_order' => 0,
            'name' => 'Other Info',
            'slug' => 'other-info',
            'status' => 1,
            'created_at' => '2025-06-03 04:46:11',
            'updated_at' => '2025-06-03 04:46:11',
        ]);

        ProductInfoCategory::create([
            'id' => 5,
            'sort_order' => 0,
            'name' => 'Attached Documents',
            'slug' => 'attached-documents',
            'status' => 1,
            'created_at' => '2025-06-03 04:46:11',
            'updated_at' => '2025-06-03 04:46:11',
        ]);
    }
}