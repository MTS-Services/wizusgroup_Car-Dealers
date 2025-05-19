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
            'name' => 'Specifications',
            'slug' => 'specifications',
        ]);

        ProductInfoCategory::create([
            'name' => 'Warranty Information',
            'slug' => 'warranty-information',
        ]);

        ProductInfoCategory::create([
            'name' => 'User Guide',
            'slug' => 'user-guide',
        ]);

        ProductInfoCategory::create([
            'name' => 'Technical Details',
            'slug' => 'technical-details',
        ]);

        ProductInfoCategory::create([
            'name' => 'Care Instructions',
            'slug' => 'care-instructions',
        ]);
    }
}
