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
        $brands = [
            ['name' => 'John Deere',       'slug' => 'john-deere',       'company_id' => 1],
            ['name' => 'Mahindra',         'slug' => 'mahindra',         'company_id' => 2],
            ['name' => 'Massey Ferguson',  'slug' => 'massey-ferguson',  'company_id' => 3],
            ['name' => 'New Holland',      'slug' => 'new-holland',      'company_id' => 4],
            ['name' => 'Kubota',           'slug' => 'kubota',           'company_id' => 5],
            ['name' => 'Sonalika',         'slug' => 'sonalika',         'company_id' => 6],
            ['name' => 'Deutz-Fahr',       'slug' => 'deutz-fahr',       'company_id' => 7],
            ['name' => 'Toyota',           'slug' => 'toyota',           'company_id' => 8],
            ['name' => 'Honda',            'slug' => 'honda',            'company_id' => 9],
            ['name' => 'Ford',             'slug' => 'ford',             'company_id' => 10],
            ['name' => 'BMW',              'slug' => 'bmw',              'company_id' => 11],
            ['name' => 'Mercedes-Benz',    'slug' => 'mercedes-benz',    'company_id' => 12],
            ['name' => 'Hyundai',          'slug' => 'hyundai',          'company_id' => 13],
            ['name' => 'Nissan',           'slug' => 'nissan',           'company_id' => 14],
            ['name' => 'Volkswagen',       'slug' => 'volkswagen',       'company_id' => 15],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
