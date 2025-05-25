<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            [
                'product_id' => 1,
                'image' => 'https://placehold.co/600x400',
                'alt' => 'John Deere 5055E Tractor'
            ],
            [
                'product_id' => 1,
                'image' => 'https://placehold.co/600x400',
                'alt' => 'Rear View of John Deere 5055E'
            ],
            [
                'product_id' => 2,
                'image' => 'https://placehold.co/600x400',
                'alt' => 'Ford Mustang Front Profile'
            ],
            [
                'product_id' => 3,
                'image' => 'https://placehold.co/600x400',
                'alt' => 'Toyota Corolla Side View'
            ],
            [
                'product_id' => 4,
                'image' => 'https://placehold.co/600x400',
                'alt' => 'Massey Ferguson MF 241 DI in field'
            ],
            [
                'product_id' => 4,
                'image' => 'https://placehold.co/600x400',
                'alt' => 'Dashboard view of MF 241 DI'
            ],
        ];

        foreach ($images as $image) {
            ProductImage::create($image);
        }
    }
}
