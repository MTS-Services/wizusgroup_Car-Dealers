<?php

namespace Database\Seeders;

use App\Models\OperationSubArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperationSubAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OperationSubArea::create([
            'country_id' => 1,
            'city_id' => 2,
            'operation_area_id' => 1,
            'name' => 'Operation Area 1',
            'slug' => 'operation-area-1',
        ]);

        OperationSubArea::create([
            'country_id'=> 4,
            'state_id'=> 1,
            'city_id' => 1,
            'operation_area_id' => 2,
            'name' => 'Operation Area 2',
            'slug' => 'operation-area-2',
        ]);
    }
}
