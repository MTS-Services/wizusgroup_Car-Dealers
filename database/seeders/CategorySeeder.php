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
            'name' => 'Agricultural Machinery',
            'slug' => 'agricultural-machinery',
            'image' => 'https://placehold.co/300x200'
        ]);

        Category::create([
            'name' => 'Construction Equipment',
            'slug' => 'construction-equipment',
            'image' => 'https://placehold.co/300x200'
        ]);

        Category::create([
            'name' => 'Vehicles',
            'slug' => 'vehicles',
            'image' => 'https://placehold.co/300x200'
        ]);

        Category::create([
            'name' => 'Parts & Accessories',
            'slug' => 'parts-accessories',
            'image' => 'https://placehold.co/300x200'
        ]);

        // ✅ New refined, real & related categories:

        Category::create([
            'name' => 'Farm Implements',
            'slug' => 'farm-implements',
            'image' => 'https://placehold.co/300x200'
        ]);
        // Tools and attachments used with agricultural machinery

        Category::create([
            'name' => 'Earthmoving Machinery',
            'slug' => 'earthmoving-machinery',
            'image' => 'https://placehold.co/300x200'
        ]);
        // Related to construction: excavators, loaders, bulldozers

        Category::create([
            'name' => 'Utility Vehicles',
            'slug' => 'utility-vehicles',
            'image' => 'https://placehold.co/300x200'
        ]);
        // Pickup trucks, ATVs, UTVs – commonly used in agriculture/construction

        Category::create([
            'name' => 'Engine & Transmission Parts',
            'slug' => 'engine-transmission-parts',
            'image' => 'https://placehold.co/300x200'
        ]);
        // Related directly to "Parts & Accessories"

    }
}
