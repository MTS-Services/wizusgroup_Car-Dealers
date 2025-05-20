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
            'name' => 'United States',
            'slug' => 'united-states',
        ]);
        Country::create([
            'name' => 'Argentina',
            'slug' => 'argentina',
        ]);
        Country::create([
            'name' => 'France',
            'slug' => 'france',
        ]);
    }
}
