<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        // California
        City::create(['country_id' => 1, 'state_id' => 1, 'name' => 'Los Angeles', 'slug' => 'los-angeles']);
        City::create(['country_id' => 1, 'state_id' => 1, 'name' => 'San Diego', 'slug' => 'san-diego']);
        City::create(['country_id' => 1, 'state_id' => 1, 'name' => 'San Francisco', 'slug' => 'san-francisco']);

        // Buenos Aires
        City::create(['country_id' => 2, 'state_id' => 4, 'name' => 'La Plata', 'slug' => 'la-plata']);
        City::create(['country_id' => 2, 'state_id' => 4, 'name' => 'Mar del Plata', 'slug' => 'mar-del-plata']);
        City::create(['country_id' => 2, 'state_id' => 4, 'name' => 'Bahía Blanca', 'slug' => 'bahia-blanca']);

        // Île-de-France
        City::create(['country_id' => 3, 'state_id' => 7, 'name' => 'Paris', 'slug' => 'paris']);
        City::create(['country_id' => 3, 'state_id' => 7, 'name' => 'Versailles', 'slug' => 'versailles']);
        City::create(['country_id' => 3, 'state_id' => 7, 'name' => 'Boulogne-Billancourt', 'slug' => 'boulogne-billancourt']);
    }
}
