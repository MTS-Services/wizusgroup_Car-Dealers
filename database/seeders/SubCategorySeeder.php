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
        Category::create(['parent_id' => 1, 'name' => 'Sedans', 'slug' => 'sedans']);             // Cars
        Category::create(['parent_id' => 2, 'name' => 'Cruisers', 'slug' => 'cruisers']);         // Motorcycles
        Category::create(['parent_id' => 3, 'name' => 'Car Tires', 'slug' => 'car-tires']);       // Car Accessories
        Category::create(['parent_id' => 4, 'name' => 'Helmets', 'slug' => 'helmets']);
    }
}
