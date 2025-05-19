<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [ 'id' => 1, 'name' => 'John Deere' ],
            [ 'id' => 2, 'name' => 'Mahindra & Mahindra' ],
            [ 'id' => 3, 'name' => 'AGCO Corporation' ],
            [ 'id' => 4, 'name' => 'CNH Industrial' ],
            [ 'id' => 5, 'name' => 'Kubota Corporation' ],
            [ 'id' => 6, 'name' => 'International Tractors Ltd' ],
            [ 'id' => 7, 'name' => 'SDF Group' ],
            [ 'id' => 8, 'name' => 'Toyota Motor Corporation' ],
            [ 'id' => 9, 'name' => 'Honda Motor Co., Ltd.' ],
            [ 'id' => 10, 'name' => 'Ford Motor Company' ],
            [ 'id' => 11, 'name' => 'BMW AG' ],
            [ 'id' => 12, 'name' => 'Daimler AG' ],
            [ 'id' => 13, 'name' => 'Hyundai Motor Company' ],
            [ 'id' => 14, 'name' => 'Nissan Motor Corporation' ],
            [ 'id' => 15, 'name' => 'Volkswagen Group' ],
        ];

        foreach ($companies as $company) {
            Company::create([
                'id' => $company['id'],
                'name' => $company['name'],
                'slug' => Str::slug($company['name']),
            ]);
        }
    }
}
