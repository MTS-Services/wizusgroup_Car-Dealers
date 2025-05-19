<?php

namespace Database\Seeders;

use App\Models\ProductInfoCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductInfoCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductInfoCategory::create([
            'name' => 'Main Damage',
            'slug' => 'main-damage',
        ]);

        ProductInfoCategory::create([
            'name' => 'Exterior Damage',
            'slug' => 'exterior-damage',
        ]);

        ProductInfoCategory::create([
            'name' => 'Air Bag Equipment',
            'slug' => 'air-bag-equipment',
        ]);

        ProductInfoCategory::create([
            'name' => 'Other Info',
            'slug' => 'other-info',
        ]);

        ProductInfoCategory::create([
            'name' => 'Attached Documents',
            'slug' => 'attached-documents',
        ]);
    }
}
