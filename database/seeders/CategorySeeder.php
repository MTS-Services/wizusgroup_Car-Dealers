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
            'image' => 'https://via.placeholder.com/300x200?text=Agricultural+Machinery'
        ]);

        Category::create([
            'name' => 'Construction Equipment',
            'slug' => 'construction-equipment',
            'image' => 'https://via.placeholder.com/300x200?text=Construction+Equipment'
        ]);

        Category::create([
            'name' => 'Vehicles',
            'slug' => 'vehicles',
            'image' => 'https://via.placeholder.com/300x200?text=Vehicles'
        ]);

        Category::create([
            'name' => 'Parts & Accessories',
            'slug' => 'parts-accessories',
            'image' => 'https://via.placeholder.com/300x200?text=Parts+%26+Accessories'
        ]);

        // ✅ New refined, real & related categories:

        Category::create([
            'name' => 'Farm Implements',
            'slug' => 'farm-implements',
            'image' => 'https://via.placeholder.com/300x200?text=Farm+Implements'
        ]);
        // Tools and attachments used with agricultural machinery

        Category::create([
            'name' => 'Earthmoving Machinery',
            'slug' => 'earthmoving-machinery',
            'image' => 'https://via.placeholder.com/300x200?text=Earthmoving+Machinery'
        ]);
        // Related to construction: excavators, loaders, bulldozers

        Category::create([
            'name' => 'Utility Vehicles',
            'slug' => 'utility-vehicles',
            'image' => 'https://via.placeholder.com/300x200?text=Utility+Vehicles'
        ]);
        // Pickup trucks, ATVs, UTVs – commonly used in agriculture/construction

        Category::create([
            'name' => 'Engine & Transmission Parts',
            'slug' => 'engine-transmission-parts',
            'image' => 'https://via.placeholder.com/300x200?text=Engine+%26+Transmission+Parts'
        ]);
        // Related directly to "Parts & Accessories"

    }
}
