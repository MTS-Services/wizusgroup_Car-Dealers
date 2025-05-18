<?php

namespace Database\Seeders;

use App\Models\TaxClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaxClass::create([
            'name' => 'Standard Tax',
            'description' => 'Default standard tax',
        ]);
        TaxClass::create([
            'name' => 'Reduced Tax',
            'description' => 'Lower rate for essentials',
        ]);
        TaxClass::create([
            'name' => 'Zero Tax',
            'description' => 'No tax applied',
        ]);
    }
}
