<?php

namespace Database\Seeders;

use App\Models\OperationArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperationAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OperationArea::create([
            'country_id' => 1,
            'city_id' => 2,
            'name' => 'Operation Area 1',
            'slug' => 'operation-area-1',
        ]);

        OperationArea::create([
            'country_id'=> 4,
            'state_id'=> 1,
            'city_id' => 1,
            'name' => 'Operation Area 2',
            'slug' => 'operation-area-2',
        ]);
    }
}
