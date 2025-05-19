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
        Category::create(['parent_id' => 5, 'name' => 'Hybrid Sedans', 'slug' => 'hybrid-sedans']);     // Sedans
        Category::create(['parent_id' => 6, 'name' => 'Classic Cruisers', 'slug' => 'classic-cruisers']); // Cruisers
        Category::create(['parent_id' => 7, 'name' => 'All-Season Tires', 'slug' => 'all-season-tires']); // Car Tires
        Category::create(['parent_id' => 8, 'name' => 'Full-face Helmets', 'slug' => 'full-face-helmets']); // Helmets
    }
}
