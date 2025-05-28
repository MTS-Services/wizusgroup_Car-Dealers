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
        'deadline' => '2024-12-31',
        'length_cm' => 6058,
        'width_cm' => 2438,
        'height_cm' => 2591,
        'max_weight_kg' => 22000,
        'shipping_port' => 1,
        'destination_port' => 2,
    ]);

    Container::create([
        'title' => '20ft Standard',
        'slug' => '20ft-standard',
        'image' => 'containers/20ft-standard-container.jpg',
        'deadline' => '2024-12-31',
        'length_cm' => 6058,
        'width_cm' => 2438,
        'height_cm' => 2591,
        'max_weight_kg' => 22000,
        'shipping_port' => 1,
        'destination_port' => 3,
    ]);

    Container::create([
        'title' => '20ft Standard Containerr',
        'slug' => '20ft-standard-containerr',
        'image' => 'containers/20ft-standard-container.jpg',
        'deadline' => '2024-12-31',
        'length_cm' => 6058,
        'width_cm' => 2438,
        'height_cm' => 2591,
        'max_weight_kg' => 22000,
        'shipping_port' => 2,
        'destination_port' => 3,
    ]);

    Container::create([
        'title' => '20ft Standard Containero',
        'slug' => '20ft-standard-containero',
        'image' => 'containers/20ft-standard-container.jpg',
        'deadline' => '2024-12-31',
        'length_cm' => 6058,
        'width_cm' => 2438,
        'height_cm' => 2591,
        'max_weight_kg' => 22000,
        'shipping_port' => 3,
        'destination_port' => 1,
    ]);

    Container::create([
        'title' => '20ft Standard Containeroo',
        'slug' => '20ft-standard-containeroo',
        'image' => 'containers/20ft-standard-container.jpg',
        'deadline' => '2024-12-31',
        'length_cm' => 6058,
        'width_cm' => 2438,
        'height_cm' => 2591,
        'max_weight_kg' => 22000,
        'shipping_port' => 2,
        'destination_port' => 1,
    ]);
}

}
