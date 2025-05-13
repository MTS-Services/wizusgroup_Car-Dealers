<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::create([
            'country_id' => 4,
            'state_id' => 1,
            'name' => 'Huntsville',
            'slug' => 'huntsville',
        ]);

        City::create([
            'country_id' => 1,
            'name' => 'Dhaka',
            'slug' => 'dhaka',
        ]);
    }
}
