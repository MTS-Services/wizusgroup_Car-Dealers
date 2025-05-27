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
            'name' => 'New York',
            'slug' => 'new-york',
            'status' => '1'
        
        ]);
        ShippingLocation::create([
            'name' => 'Los Angeles',
            'slug' => 'los-angeles',
            'status' => '1'

        ]);
        ShippingLocation::create([
            'name' => 'Chicago',
            'slug' => 'chicago',
            'status' => '1'

        ]);
        ShippingLocation::create([
            'name' => 'Houston',
            'slug' => 'houston',
            'status' => '1'

        ]);
        ShippingLocation::create([
            'name' => 'Phoenix',
            'slug' => 'phoenix',
            'status' => '1'

        ]);
        ShippingLocation::create([
            'name' => 'Philadelphia',
            'slug' => 'philadelphia',
            'status' => '1'

        ]);
    }
}
