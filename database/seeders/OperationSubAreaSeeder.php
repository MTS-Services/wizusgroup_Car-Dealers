<?php

namespace Database\Seeders;

use App\Models\OperationSubArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperationSubAreaSeeder extends Seeder
{
    public function run(): void
    {
        // Downtown LA
        OperationSubArea::create(['country_id' => 1, 'state_id' => 1, 'city_id' => 1, 'operation_area_id' => 1, 'name' => 'Financial District', 'slug' => 'financial-district']);
        OperationSubArea::create(['country_id' => 1, 'state_id' => 1, 'city_id' => 1, 'operation_area_id' => 1, 'name' => 'Arts District', 'slug' => 'arts-district']);
        OperationSubArea::create(['country_id' => 1, 'state_id' => 1, 'city_id' => 1, 'operation_area_id' => 1, 'name' => 'Fashion District', 'slug' => 'fashion-district']);

        // Centro, La Plata
        OperationSubArea::create(['country_id' => 2, 'state_id' => 4, 'city_id' => 4, 'operation_area_id' => 4, 'name' => 'Plaza Moreno', 'slug' => 'plaza-moreno']);
        OperationSubArea::create(['country_id' => 2, 'state_id' => 4, 'city_id' => 4, 'operation_area_id' => 4, 'name' => 'Catedral', 'slug' => 'catedral']);
        OperationSubArea::create(['country_id' => 2, 'state_id' => 4, 'city_id' => 4, 'operation_area_id' => 4, 'name' => 'Diagonal 80', 'slug' => 'diagonal-80']);

        // Montmartre, Paris
        OperationSubArea::create(['country_id' => 3, 'state_id' => 7, 'city_id' => 7, 'operation_area_id' => 7, 'name' => 'Place du Tertre', 'slug' => 'place-du-tertre']);
        OperationSubArea::create(['country_id' => 3, 'state_id' => 7, 'city_id' => 7, 'operation_area_id' => 7, 'name' => 'Rue Lepic', 'slug' => 'rue-lepic']);
        OperationSubArea::create(['country_id' => 3, 'state_id' => 7, 'city_id' => 7, 'operation_area_id' => 7, 'name' => 'Abbesses', 'slug' => 'abbesses']);
    }
}
