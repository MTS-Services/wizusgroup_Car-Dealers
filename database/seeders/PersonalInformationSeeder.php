<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\PersonalInformation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PersonalInformation::create([
            'profile_id' => 1,
            'profile_type' => Admin::class,
            'dob' => '2001-01-01',
            'gender' => PersonalInformation::GENDER_MALE,
            'emergency_phone' => '1234567890',
            'father_name' => 'John Doe',
            'mother_name' => 'Jane Doe',
            'nationality' => 'Japanese',
            'bio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);
        
        PersonalInformation::create([
           'profile_id' => 2,
            'profile_type' => User::class,
            'dob' => '2001-01-01',
            'gender' => PersonalInformation::GENDER_MALE,
            'emergency_phone' => '1234567890',
            'father_name' => 'Duane Smith',
            'mother_name' => 'Sally Smith',  
            'nationality' => 'American',
            'bio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);
    }
}
