<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Auction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AuctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Auction::create([
            'product_id' => 1, // John Deere 5075E Tractor
            'sort_order' => 1,
            'title' => 'Auction for John Deere 5075E Tractor',
            'slug' => 'john-deere-5075e-tractor',
            'description' => 'Bid on a well-maintained John Deere 5075E utility tractor with low hours.',
            'start_price' => 25000.00,
            'reserve_price' => 30000.00,
            'buy_now_price' => 32000.00,
            'increment_amount' => 500.00,
            'start_date' => Carbon::now()->addDays(1),
            'end_date' => Carbon::now()->addDays(10),
            'status' => 1, // STATUS_SCHEDULED
            'is_featured' => true,
            'meta_title' => 'John Deere Tractor Auction',
            'meta_description' => 'Participate in the auction for a reliable John Deere 5075E Tractor. Starting bid $25,000.',
        ]);

        Auction::create([
            'product_id' => 2, // Caterpillar 320 Excavator
            'sort_order' => 2,
            'title' => 'Auction for Caterpillar 320 Excavator',
            'slug' => 'caterpillar-320-excavator',
            'description' => 'Heavy-duty Caterpillar 320 excavator with recent maintenance, ready for work.',
            'start_price' => 120000.00,
            'reserve_price' => 135000.00,
            'buy_now_price' => 145000.00,
            'increment_amount' => 1000.00,
            'start_date' => Carbon::now()->subDays(2),
            'end_date' => Carbon::now()->addDays(5),
            'status' => 2, // Example: STATUS_OPEN
            'is_featured' => false,
            'meta_title' => 'Caterpillar 320 Excavator Auction',
            'meta_description' => 'Join the live auction for a Caterpillar 320 Excavator. Heavy-duty and reliable.',
        ]);

        Auction::create([
            'product_id' => 3, // Toyota Hilux 2022
            'sort_order' => 3,
            'title' => 'Toyota Hilux 2022 Auction',
            'slug' => 'toyota-hilux-2022',
            'description' => 'Top-trim Toyota Hilux 2022 with 4x4 drivetrain and advanced features.',
            'start_price' => 30000.00,
            'reserve_price' => 37000.00,
            'buy_now_price' => 39000.00,
            'increment_amount' => 750.00,
            'start_date' => Carbon::now()->addDays(3),
            'end_date' => Carbon::now()->addDays(12),
            'status' => 1, // STATUS_SCHEDULED
            'is_featured' => true,
            'meta_title' => 'Toyota Hilux Auction',
            'meta_description' => 'Bid for the rugged 2022 Toyota Hilux in our upcoming auction.',
        ]);
    }
}
