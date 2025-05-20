<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Admin;
use App\Models\City;
use App\Models\Country;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function PHPSTORM_META\type;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Address::create([
            'profile_id' => 1,
            'profile_type' => Admin::class,
            'type' => Address::TYPE_PERSONAL,
            'country_id' => Country::first()->id,
            'city_id' => 1,
            'address_line_1' => 'Address Line 1',
            'postal_code' => '12345',
        ]);
        Address::create([
            'profile_id' => 1,
            'profile_type' => User::class,
            'type' => Address::TYPE_PERSONAL,
            'country_id' => Country::first()->id,
            'city_id' => 1,
            'address_line_1' => 'Address Line 1',
            'postal_code' => '12345',
        ]);
    }
}
