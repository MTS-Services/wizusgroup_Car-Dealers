<?php

namespace Database\Seeders;

use App\Models\Container;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Container::create([
            'title' => '20ft Standard Container',
            'slug' => '20ft-standard-container',
            'image' => 'containers/20ft-standard-container.jpg',
            'deadline' => '2025-06-01',
            'length_m' => 6058,
            'width_m' => 2438,
            'height_m' => 2591,
            'max_weight_kg' => 22000,
            'base_cost' => 100,
            'per_kg_cost' => 100,
            'per_cbm_cost' => 100,
            'shipping_port' => 1,
            'destination_port' => 2,
            'status' => Container::STATUS_ACTIVE,
        ]);

        Container::create([
            'title' => '20ft Standard',
            'slug' => '20ft-standard',
            'image' => 'containers/20ft-standard-container.jpg',
            'deadline' => '2025-06-05',
            'length_m' => 6058,
            'width_m' => 2438,
            'height_m' => 2591,
            'max_weight_kg' => 22000,
            'base_cost' => 200,
            'per_kg_cost' => 200,
            'per_cbm_cost' => 400,
            'shipping_port' => 1,
            'destination_port' => 3,
            'status' => Container::STATUS_ACTIVE,
        ]);

        Container::create([
            'title' => '20ft Standard Containerr',
            'slug' => '20ft-standard-containerr',
            'image' => 'containers/20ft-standard-container.jpg',
            'deadline' => '2025-06-10',
            'length_m' => 6058,
            'width_m' => 2438,
            'height_m' => 2591,
            'max_weight_kg' => 22000,
            'base_cost' => 200,
            'per_kg_cost' => 300,
            'per_cbm_cost' => 200,
            'shipping_port' => 2,
            'destination_port' => 3,
            'status' => Container::STATUS_ACTIVE,
        ]);
    }

}
