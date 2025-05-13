<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        State::create([
            "country_id"=> 4,
            "name"=> "Alabama",
            "slug"=> "alabama",
        ]);
        State::create([
            "country_id"=> 4,
            "name"=> "Alaska",
            "slug"=> "alaska",
        ]);
        State::create([
            "country_id"=> 4,
            "name"=> "Arizona",
            "slug"=> "arizona",
        ]);
    }
}
