<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::create([
            'name' => 'Bangladesh',
            'slug' => 'bangladesh',
        ]);
        Country::create([
            'name' => 'India',
            'slug' => 'india',
        ]);
        Country::create([
            'name' => 'Pakistan',
            'slug' => 'pakistan',
        ]);
        Country::create([
            'name' => 'United States',
            'slug' => 'united-states',
        ]);
    }
}
