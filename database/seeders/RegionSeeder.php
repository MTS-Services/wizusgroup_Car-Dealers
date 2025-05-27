<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Region::create([
            'name' => 'Dhaka',
            'slug' => 'dhaka',
            'description' => 'Dhaka is the capital city of Bangladesh.',
            'status' => 1,
        ]);
        Region::create([
            'name' => 'Chittagong',
            'slug' => 'chittagong',
            'description' => 'Chittagong is a major coastal city in Bangladesh.',
            'status' => 1,
        ]);
        Region::create([
            'name' => 'Khulna',
            'slug' => 'khulna',
            'description' => 'Khulna is known for its port and the Sundarbans mangrove forest.',
            'status' => 1,
        ]);
        Region::create([
            'name' => 'Rajshahi',
            'slug' => 'rajshahi',
            'description' => 'Rajshahi is famous for its silk and mangoes.',
            'status' => 1,
        ]);
        Region::create([
            'name' => 'Sylhet',
            'slug' => 'sylhet',
            'description' => 'Sylhet is known for its tea gardens and natural beauty.',
            'status' => 1,
        ]);
    }
}
