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
        Category::create(['name' => 'Agricultural Machinery', 'slug' => 'agricultural-machinery']);
        Category::create(['name' => 'Construction Equipment', 'slug' => 'construction-equipment']);
        Category::create(['name' => 'Vehicles', 'slug' => 'vehicles']);
        Category::create(['name' => 'Parts & Accessories', 'slug' => 'parts-accessories']);
    }
}
