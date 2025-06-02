<?php

namespace Database\Seeders;

use App\Models\ShippingLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShippingLocation::create([
            'country_id' => '1',
            'state_id' => '1',
            'city_id' => '1',
            'name' => 'New York',
            'slug' => 'new-york',
            'status' => '1'
        
        ]);
        ShippingLocation::create([
            'country_id' => '1',
            'state_id' => '1',
            'city_id' => '1',
            'name' => 'Los Angeles',
            'slug' => 'los-angeles',
            'status' => '1'

        ]);
        ShippingLocation::create([
            'country_id' => '1',
            'state_id' => '1',
            'city_id' => '1',
            'name' => 'Chicago',
            'slug' => 'chicago',
            'status' => '1'

        ]);
        ShippingLocation::create([
            'country_id' => '1',
            'state_id' => '1',
            'city_id' => '1',
            'name' => 'Houston',
            'slug' => 'houston',
            'status' => '1'

        ]);
        ShippingLocation::create([
            'country_id' => '1',
            'state_id' => '1',
            'city_id' => '1',
            'name' => 'Phoenix',
            'slug' => 'phoenix',
            'status' => '1'

        ]);
        ShippingLocation::create([
            'country_id' => '1',
            'state_id' => '1',
            'city_id' => '1',
            'name' => 'Philadelphia',
            'slug' => 'philadelphia',
            'status' => '1'

        ]);
    }
}
