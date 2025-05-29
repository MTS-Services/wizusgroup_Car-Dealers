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
            'length_cm' => 6058,
            'width_cm' => 2438,
            'height_cm' => 2591,
            'max_weight_kg' => 22000,
            'shipping_port' => 1,
            'destination_port' => 2,
            'status' => Container::STATUS_ACTIVE,
        ]);

        Container::create([
            'title' => '20ft Standard',
            'slug' => '20ft-standard',
            'image' => 'containers/20ft-standard-container.jpg',
            'deadline' => '2025-06-05',
            'length_cm' => 6058,
            'width_cm' => 2438,
            'height_cm' => 2591,
            'max_weight_kg' => 22000,
            'shipping_port' => 1,
            'destination_port' => 3,
            'status' => Container::STATUS_ACTIVE,
        ]);

        Container::create([
            'title' => '20ft Standard Containerr',
            'slug' => '20ft-standard-containerr',
            'image' => 'containers/20ft-standard-container.jpg',
            'deadline' => '2025-06-10',
            'length_cm' => 6058,
            'width_cm' => 2438,
            'height_cm' => 2591,
            'max_weight_kg' => 22000,
            'shipping_port' => 2,
            'destination_port' => 3,
            'status' => Container::STATUS_ACTIVE,
        ]);
    }

}
