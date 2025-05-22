<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        Banner::create([
            'title' => 'Summer Sale 2025',
            'subtitle' => 'Up to 40% off on all vehicles',
            'image' => 'https://placehold.co/1920x1080',
            'url' => 'https://example.com/summer-sale',
            'start_date' => '2025-06-01',
            'end_date' => '2025-06-30',
        ]);

        Banner::create([
            'title' => 'New Arrivals: Electric Vehicles',
            'subtitle' => 'Discover our latest eco-friendly lineup',
            'image' => 'https://placehold.co/1920x1080',
            'url' => 'https://example.com/electric-vehicles',
            'start_date' => '2025-05-10',
            'end_date' => '2025-07-10',
        ]);

        Banner::create([
            'title' => 'Limited Time Offer',
            'subtitle' => 'Get $1000 off on select models',
            'image' => 'https://placehold.co/1920x1080',
            'url' => 'https://example.com/limited-offer',
            'start_date' => '2025-05-20',
            'end_date' => '2025-06-05',
        ]);
    }
}
