<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'first_name' => 'Alice',
            'last_name' => 'Johnson',
            'username' => 'alicej',
            'email' => 'alice.johnson@example.com',
            'email_verified_at' => now(),
            'password' =>'123456789',
        ]);

        Supplier::create([
            'first_name' => 'Bob',
            'last_name' => 'Smith',
            'username' => 'bobsmith',
            'email' => 'bob.smith@example.com',
            'email_verified_at' => now(),
            'password' =>'123456789',
        ]);

        Supplier::create([
            'first_name' => 'Carol',
            'last_name' => 'Miller',
            'username' => 'carolm',
            'email' => 'carol.miller@example.com',
            'email_verified_at' => now(),
            'password' =>'123456789',
        ]);

        Supplier::create([
            'first_name' => 'David',
            'last_name' => 'Lee',
            'username' => 'davidlee',
            'email' => 'david.lee@example.com',
            'email_verified_at' => now(),
            'password' =>'123456789',
        ]);

        Supplier::create([
            'first_name' => 'Eva',
            'last_name' => 'Wong',
            'username' => 'evawong',
            'email' => 'eva.wong@example.com',
            'email_verified_at' => now(),
            'password' =>'123456789',
        ]);
    }
}
