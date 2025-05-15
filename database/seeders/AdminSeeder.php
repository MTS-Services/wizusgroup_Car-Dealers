<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = Admin::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@dev.com',
            'email_verified_at' => now(),
            'password' => 'superadmin@dev.com',
            'role_id' => 1
        ]);
        $superadmin->assignRole($superadmin->role->name);
        $admin = Admin::create([
            'first_name' => 'New',
            'last_name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@dev.com',
            'email_verified_at' => now(),
            'password' => 'admin@dev.com',
            'role_id' => 2
        ]);
        $admin->assignRole($admin->role->name);

        $test = Admin::create([
            'first_name' => 'Test',
            'last_name' => 'Admin',
            'username' => 'testadmin',
            'email' => 'testadmin@dev.com',
            'password' => 'testadmin@dev.com',
            'role_id' => 2
        ]);
        $test->assignRole($test->role->name);
    }
}
