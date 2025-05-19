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
         Category::create(['name' => 'Cars', 'slug' => 'cars']);
        Category::create(['name' => 'Motorcycles', 'slug' => 'motorcycles']);
        Category::create(['name' => 'Car Accessories', 'slug' => 'car-accessories']);
        Category::create(['name' => 'Bike Gear', 'slug' => 'bike-gear']);
    }
}
