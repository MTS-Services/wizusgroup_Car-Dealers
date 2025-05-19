<?php

namespace Database\Seeders;

use App\Models\OperationArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperationAreaSeeder extends Seeder
{
    public function run(): void
    {
        // Los Angeles
        OperationArea::create(['country_id' => 1, 'state_id' => 1, 'city_id' => 1, 'name' => 'Downtown LA', 'slug' => 'downtown-la']);
        OperationArea::create(['country_id' => 1, 'state_id' => 1, 'city_id' => 1, 'name' => 'Hollywood', 'slug' => 'hollywood']);
        OperationArea::create(['country_id' => 1, 'state_id' => 1, 'city_id' => 1, 'name' => 'Santa Monica', 'slug' => 'santa-monica']);

        // La Plata
        OperationArea::create(['country_id' => 2, 'state_id' => 4, 'city_id' => 4, 'name' => 'Centro', 'slug' => 'centro']);
        OperationArea::create(['country_id' => 2, 'state_id' => 4, 'city_id' => 4, 'name' => 'Tolosa', 'slug' => 'tolosa']);
        OperationArea::create(['country_id' => 2, 'state_id' => 4, 'city_id' => 4, 'name' => 'Ringuelet', 'slug' => 'ringuelet']);

        // Paris
        OperationArea::create(['country_id' => 3, 'state_id' => 7, 'city_id' => 7, 'name' => 'Montmartre', 'slug' => 'montmartre']);
        OperationArea::create(['country_id' => 3, 'state_id' => 7, 'city_id' => 7, 'name' => 'La Défense', 'slug' => 'la-defense']);
        OperationArea::create(['country_id' => 3, 'state_id' => 7, 'city_id' => 7, 'name' => 'Latin Quarter', 'slug' => 'latin-quarter']);
    }
}
