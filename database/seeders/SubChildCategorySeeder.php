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
        // 🚜 Sub-child categories for Agricultural Machinery -> Tractors
        Category::create(['parent_id' => 5, 'name' => 'Compact Tractors', 'slug' => 'compact-tractors']);
        Category::create(['parent_id' => 5, 'name' => 'Utility Tractors', 'slug' => 'utility-tractors']);
        Category::create(['parent_id' => 5, 'name' => 'Row Crop Tractors', 'slug' => 'row-crop-tractors']);

        // 🚜 Agricultural Machinery -> Harvesters
        Category::create(['parent_id' => 6, 'name' => 'Combine Harvesters', 'slug' => 'combine-harvesters']);
        Category::create(['parent_id' => 6, 'name' => 'Forage Harvesters', 'slug' => 'forage-harvesters']);
        Category::create(['parent_id' => 6, 'name' => 'Sugarcane Harvesters', 'slug' => 'sugarcane-harvesters']);

        // 🚜 Agricultural Machinery -> Ploughs
        Category::create(['parent_id' => 7, 'name' => 'Disc Ploughs', 'slug' => 'disc-ploughs']);
        Category::create(['parent_id' => 7, 'name' => 'Mouldboard Ploughs', 'slug' => 'mouldboard-ploughs']);
        Category::create(['parent_id' => 7, 'name' => 'Chisel Ploughs', 'slug' => 'chisel-ploughs']);

        // 🏗 Construction Equipment -> Excavators
        Category::create(['parent_id' => 8, 'name' => 'Mini Excavators', 'slug' => 'mini-excavators']);
        Category::create(['parent_id' => 8, 'name' => 'Crawler Excavators', 'slug' => 'crawler-excavators']);
        Category::create(['parent_id' => 8, 'name' => 'Dragline Excavators', 'slug' => 'dragline-excavators']);

        // 🏗 Construction Equipment -> Bulldozers
        Category::create(['parent_id' => 9, 'name' => 'Crawler Bulldozers', 'slug' => 'crawler-bulldozers']);
        Category::create(['parent_id' => 9, 'name' => 'Wheel Bulldozers', 'slug' => 'wheel-bulldozers']);
        Category::create(['parent_id' => 9, 'name' => 'Mini Bulldozers', 'slug' => 'mini-bulldozers']);

        // 🏗 Construction Equipment -> Cranes
        Category::create(['parent_id' => 10, 'name' => 'Tower Cranes', 'slug' => 'tower-cranes']);
        Category::create(['parent_id' => 10, 'name' => 'Mobile Cranes', 'slug' => 'mobile-cranes']);
        Category::create(['parent_id' => 10, 'name' => 'Rough Terrain Cranes', 'slug' => 'rough-terrain-cranes']);

        // 🚗 Vehicles -> Cars
        Category::create(['parent_id' => 11, 'name' => 'Sedan', 'slug' => 'sedan']);
        Category::create(['parent_id' => 11, 'name' => 'SUV', 'slug' => 'suv']);
        Category::create(['parent_id' => 11, 'name' => 'Hatchback', 'slug' => 'hatchback']);

        // 🚗 Vehicles -> Motorcycles
        Category::create(['parent_id' => 12, 'name' => 'Cruiser', 'slug' => 'cruiser']);
        Category::create(['parent_id' => 12, 'name' => 'Sport Bike', 'slug' => 'sport-bike']);
        Category::create(['parent_id' => 12, 'name' => 'Scooter', 'slug' => 'scooter']);

        // 🚗 Vehicles -> Trucks
        Category::create(['parent_id' => 13, 'name' => 'Pickup Trucks', 'slug' => 'pickup-trucks']);
        Category::create(['parent_id' => 13, 'name' => 'Dump Trucks', 'slug' => 'dump-trucks']);
        Category::create(['parent_id' => 13, 'name' => 'Box Trucks', 'slug' => 'box-trucks']);

        // 🧩 Parts & Accessories -> Engine Parts
        Category::create(['parent_id' => 14, 'name' => 'Pistons', 'slug' => 'pistons']);
        Category::create(['parent_id' => 14, 'name' => 'Engine Blocks', 'slug' => 'engine-blocks']);
        Category::create(['parent_id' => 14, 'name' => 'Timing Belts', 'slug' => 'timing-belts']);

        // 🧩 Parts & Accessories -> Body Parts
        Category::create(['parent_id' => 15, 'name' => 'Bumpers', 'slug' => 'bumpers']);
        Category::create(['parent_id' => 15, 'name' => 'Doors', 'slug' => 'doors']);
        Category::create(['parent_id' => 15, 'name' => 'Fenders', 'slug' => 'fenders']);

        // 🧩 Parts & Accessories -> Tires & Wheels
        Category::create(['parent_id' => 16, 'name' => 'All-Terrain Tires', 'slug' => 'all-terrain-tires']);
        Category::create(['parent_id' => 16, 'name' => 'Performance Tires', 'slug' => 'performance-tires']);
        Category::create(['parent_id' => 16, 'name' => 'Alloy Wheels', 'slug' => 'alloy-wheels']);
    }
}
