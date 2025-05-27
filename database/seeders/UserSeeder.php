<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'New',
            'last_name' => 'User',
            'username' => 'user',
            'email' => 'user@dev.com',
            'password' => 'user@dev.com',
            'email_verified_at' => now(),
            'business_type' => User::BUSINESS_TYPE_INDIVIDUAL,
            'business_name' => User::BUSINESS_NAME_DEMOLITION_PARTS,
            'business_information' => 'User Business Information',
            'business_line' => User::BUSINESS_LINE_DAMAGED_CAR,
            'how_know' => User::KNOW_STAFF,
            'receive_promotion_email' => User::RECEIVE_PROMOTION_EMAIL,
            'accept_terms' => User::ACCEPT_TERMS
        ]);
    }
}
