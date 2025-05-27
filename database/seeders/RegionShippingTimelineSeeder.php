<?php

namespace Database\Seeders;

use App\Models\RegionShippingTimeline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionShippingTimelineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       RegionShippingTimeline::create([
            'region_id' => 1,
            'min_days' => '2',
            'max_days' => '3',
            'ports' => 'Dhaka, Chittagong',
        
        ]);
       RegionShippingTimeline::create([
            'region_id' => 2,
            'min_days' => '3',
            'max_days' => '3',
            'ports' => 'Dhaka, Chittagong',
        
        ]);
       RegionShippingTimeline::create([
            'region_id' => 3,
            'min_days' => '4',
            'max_days' => '3',
            'ports' => 'Dhaka, Chittagong',
        
        ]);
       RegionShippingTimeline::create([
            'region_id' => 4,
            'min_days' => '5',
            'max_days' => '3',
            'ports' => 'Dhaka, Chittagong',
        
        ]);
    }
}
