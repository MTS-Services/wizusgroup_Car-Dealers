<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



        Category::create([
            'name' => 'Sub Category 1',
            'slug' => 'sub-category-1',
            'parent_id' => 1,
        ]);
        Category::create([
            'name' => 'Sub Category 2',
            'slug' => 'sub-category-2',
            'parent_id' => 1,
        ]);
        Category::create([
            'name' => 'Sub Category 3',
            'slug' => 'sub-category-3',
            'parent_id' => 2,
        ]);
        Category::create([
            'name' => 'Sub Category 4',
            'slug' => 'sub-category-4',
            'parent_id' => 2,
        ]);
        Category::create([
            'name' => 'Sub Category 5',
            'slug' => 'sub-category-5',
            'parent_id' => 3,
        ]);
        Category::create([
            'name' => 'Sub Category 6',
            'slug' => 'sub-category-6',
            'parent_id' => 3,
        ]);
    }
}
