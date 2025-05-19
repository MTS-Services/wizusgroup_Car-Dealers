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
                'image' => 'https://via.placeholder.com/600x400.png?text=John+Deere+5055E',
                'alt' => 'John Deere 5055E Tractor'
            ],
            [
                'product_id' => 1,
                'image' => 'https://via.placeholder.com/600x400.png?text=5055E+Rear+View',
                'alt' => 'Rear View of John Deere 5055E'
            ],
            [
                'product_id' => 2,
                'image' => 'https://via.placeholder.com/600x400.png?text=Ford+Mustang',
                'alt' => 'Ford Mustang Front Profile'
            ],
            [
                'product_id' => 3,
                'image' => 'https://via.placeholder.com/600x400.png?text=Toyota+Corolla',
                'alt' => 'Toyota Corolla Side View'
            ],
            [
                'product_id' => 4,
                'image' => 'https://via.placeholder.com/600x400.png?text=Massey+Ferguson+MF+241+DI',
                'alt' => 'Massey Ferguson MF 241 DI in field'
            ],
            [
                'product_id' => 4,
                'image' => 'https://via.placeholder.com/600x400.png?text=MF+241+DI+Dashboard',
                'alt' => 'Dashboard view of MF 241 DI'
            ],
        ];

        foreach ($images as $image) {
            ProductImage::create($image);
        }
    }
}
