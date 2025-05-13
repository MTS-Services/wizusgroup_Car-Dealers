<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::create([
            'title'=> 'Banner 1',
            'subtitle'=> 'Banner 1',
            'image'=> 'banners/1.jpg',
            'url'=> '#',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ]);
        Banner::create([
            'title'=> 'Banner 2',
            'subtitle'=> 'Banner 2',
            'image'=> 'banners/2.jpg',
            'url'=> '#',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ]);
        Banner::create([
            'title'=> 'Banner 3',
            'subtitle'=> 'Banner 3',
            'image'=> 'banners/3.jpg',
            'url'=> '#',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ]);
        Banner::create([
            'title'=> 'Banner 4',
            'subtitle'=> 'Banner 4',
            'image'=> 'banners/4.jpg',
            'url'=> '#',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ]);
    }
}
