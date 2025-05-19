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
        // United States
        State::create(['country_id' => 1, 'name' => 'California', 'slug' => 'california']);
        State::create(['country_id' => 1, 'name' => 'Texas', 'slug' => 'texas']);
        State::create(['country_id' => 1, 'name' => 'New York', 'slug' => 'new-york']);

        // Argentina
        State::create(['country_id' => 2, 'name' => 'Buenos Aires', 'slug' => 'buenos-aires']);
        State::create(['country_id' => 2, 'name' => 'Córdoba', 'slug' => 'cordoba']);
        State::create(['country_id' => 2, 'name' => 'Santa Fe', 'slug' => 'santa-fe']);

        // France
        State::create(['country_id' => 3, 'name' => 'Île-de-France', 'slug' => 'ile-de-france']);
        State::create(['country_id' => 3, 'name' => 'Provence-Alpes-Côte d\'Azur', 'slug' => 'provence-alpes-cote-dazur']);
        State::create(['country_id' => 3, 'name' => 'Nouvelle-Aquitaine', 'slug' => 'nouvelle-aquitaine']);
    }
}
