<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubChildCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          Category::create([
            'name' => 'Sub Child Category 1',
            'slug' => 'sub-child-category-1',
            'parent_id' => 4,
        ]);
        Category::create([
            'name' => 'Sub Child Category 2',
            'slug' => 'sub-child-category-2',
            'parent_id' => 4,
        ]);
        Category::create([
            'name' => 'Sub Child Category 3',
            'slug' => 'sub-child-category-3',
            'parent_id' => 5,
        ]);
        Category::create([
            'name' => 'Sub Child Category 4',
            'slug' => 'sub-child-category-4',
            'parent_id' => 5,
        ]);
        Category::create([
            'name' => 'Sub Child Category 5',
            'slug' => 'sub-child-category-5',
            'parent_id' => 6,
        ]);
        Category::create([
            'name' => 'Sub Child Category 6',
            'slug' => 'sub-child-category-6',
            'parent_id' => 6,
        ]);
    }
}
