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
        // Subcategories for Agricultural Machinery
        Category::create(['parent_id' => 1, 'name' => 'Tractors', 'slug' => 'tractors']);
        Category::create(['parent_id' => 1, 'name' => 'Harvesters', 'slug' => 'harvesters']);
        Category::create(['parent_id' => 1, 'name' => 'Ploughs', 'slug' => 'ploughs']);

        // Subcategories for Construction Equipment
        Category::create(['parent_id' => 2, 'name' => 'Excavators', 'slug' => 'excavators']);
        Category::create(['parent_id' => 2, 'name' => 'Bulldozers', 'slug' => 'bulldozers']);
        Category::create(['parent_id' => 2, 'name' => 'Cranes', 'slug' => 'cranes']);

        // Subcategories for Vehicles
        Category::create(['parent_id' => 3, 'name' => 'Cars', 'slug' => 'cars']);
        Category::create(['parent_id' => 3, 'name' => 'Motorcycles', 'slug' => 'motorcycles']);
        Category::create(['parent_id' => 3, 'name' => 'Trucks', 'slug' => 'trucks']);

        // Subcategories for Parts & Accessories
        Category::create(['parent_id' => 4, 'name' => 'Engine Parts', 'slug' => 'engine-parts']);
        Category::create(['parent_id' => 4, 'name' => 'Body Parts', 'slug' => 'body-parts']);
        Category::create(['parent_id' => 4, 'name' => 'Tires & Wheels', 'slug' => 'tires-wheels']);
    }
}
