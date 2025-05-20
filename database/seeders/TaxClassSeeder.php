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
            'name' => 'Standard Rate',
            'description' => 'Applies to most products including vehicles, machinery, and equipment.',
        ]);

        TaxClass::create([
            'name' => 'Reduced Rate',
            'description' => 'Applicable to selected essential goods such as agricultural equipment and green technology.',
        ]);

        TaxClass::create([
            'name' => 'Zero Rate',
            'description' => 'Used for tax-exempt goods such as exported machinery or non-taxable services.',
        ]);

        TaxClass::create([
            'name' => 'Luxury Goods Tax',
            'description' => 'Applies to premium or luxury items such as high-end vehicles and accessories.',
        ]);
    }
}
