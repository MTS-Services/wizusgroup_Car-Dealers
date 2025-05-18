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
            'name' => 'John Deere',
            'slug' => 'john-deere',
        ]);
        Brand::create([
            'name' => 'Mahindra',
            'slug' => 'mahindra',
        ]);
        Brand::create([
            'name' => 'Massey Ferguson',
            'slug' => 'massey-ferguson',
        ]);
        Brand::create([
            'name' => 'New Holland',
            'slug' => 'new-holland',
        ]);
        Brand::create([
            'name' => 'Kubota',
            'slug' => 'kubota',
        ]);
        Brand::create([
            'name' => 'Sonalika',
            'slug' => 'sonalika',
        ]);
        Brand::create([
            'name' => 'Deutz-Fahr',
            'slug' => 'deutz-fahr',
        ]);
        Brand::create([
            'name' => 'Toyota',
            'slug' => 'toyota',
        ]);
        Brand::create([
            'name' => 'Honda',
            'slug' => 'honda',
        ]);
        Brand::create([
            'name' => 'Ford',
            'slug' => 'ford',
        ]);
        Brand::create([
            'name' => 'BMW',
            'slug' => 'bmw',
        ]);
        Brand::create([
            'name' => 'Mercedes-Benz',
            'slug' => 'mercedes-benz',
        ]);
        Brand::create([
            'name' => 'Hyundai',
            'slug' => 'hyundai ',
        ]);
        Brand::create([
            'name' => 'Nissan',
            'slug' => 'nissan ',
        ]);
        Brand::create([
            'name' => 'Volkswagen',
            'slug' => 'volkswagen ',
        ]);
    }
}
