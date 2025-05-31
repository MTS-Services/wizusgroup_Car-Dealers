<?php

namespace Database\Seeders;

use App\Models\ContainerProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContainerProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContainerProduct::create(
            [
                'container_id' => 1,
                'product_id' => 1,
                'price' => 2000,
                'reserve_price' => 1000,
            ]
        );
        ContainerProduct::create(
            [
                'container_id' => 1,
                'product_id' => 2,
                'price' => 4400,
                'reserve_price' => 2200,
            ]
        );
        ContainerProduct::create(
            [
                'container_id' => 1,
                'product_id' => 3,
                'price' => 6600,
                'reserve_price' => 3300,
            ]
        );

        ContainerProduct::create(
            [
                'container_id' => 2,
                'product_id' => 4,
                'price' => 5500,
                'reserve_price' => 3000,
            ]
        );
        ContainerProduct::create(
            [
                'container_id' => 3,
                'product_id' => 5,
                'price' => 4000,
                'reserve_price' => 2000,
            ]
        );
    }
}
