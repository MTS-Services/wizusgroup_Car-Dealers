<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Category 1',
            'slug' => 'category-1',
        ]);
        Category::create([
            'name' => 'Category 2',
            'slug' => 'category-2',
        ]);
        Category::create([
            'name' => 'Category 3',
            'slug' => 'category-3',
        ]);
        Category::create([
            'name' => 'Category 5',
            'slug' => 'category-5',
            'is_featured' => 1,
        ]);
        Category::create([
            'name' => 'Category 6',
            'slug' => 'category-6',
            'is_featured' => 1,
        ]);
        Category::create([
            'name' => 'Category 7',
            'slug' => 'category-7',
            'is_featured' => 1,
        ]);

        // Category::factory(50)->create();
    }
}
