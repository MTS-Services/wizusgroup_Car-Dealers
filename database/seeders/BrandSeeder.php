<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::create([
            'name' => 'Brand 1',
            'slug' => 'brand-1',
        ]);
        Brand::create([
            'name' => 'Brand 2',
            'slug' => 'brand-2',
        ]);
        Brand::create([
            'name' => 'Brand 3',
            'slug' => 'brand-3',
        ]);
        Brand::create([
            'name' => 'Brand 4',
            'slug' => 'brand-4',
        ]);
        Brand::create([
            'name' => 'Brand 5',
            'slug' => 'brand-5',
        ]);
    }
}
