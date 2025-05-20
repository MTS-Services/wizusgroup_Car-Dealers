<?php

namespace Database\Seeders;

use App\Models\TaxRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaxRate::create([
            'tax_class_id' => 1, // Standard Rate
            'country_id' => 1,   // United States
            'state_id' => 1,     // California
            'city_id' => 1,      // Los Angeles
            'rate' => 7.25,
            'name' => 'CA Standard Tax',
            'priority' => TaxRate::PRIORITY_HIGH,
            'compound' => TaxRate::COMPOUND_FALSE,
        ]);

        TaxRate::create([
            'tax_class_id' => 2, // Reduced Rate
            'country_id' => 2,   // Argentina
            'state_id' => 4,     // Buenos Aires Province
            'city_id' => 4,      // La Plata
            'rate' => 5.00,
            'name' => 'AR Reduced Tax',
            'priority' => TaxRate::PRIORITY_NORMAL,
            'compound' => TaxRate::COMPOUND_FALSE,
        ]);

        TaxRate::create([
            'tax_class_id' => 3, // Zero Rate
            'country_id' => 3,   // France
            'state_id' => 7,     // Île-de-France
            'city_id' => 7,      // Paris
            'rate' => 0.00,
            'name' => 'FR Zero Tax',
            'priority' => TaxRate::PRIORITY_LOW,
            'compound' => TaxRate::COMPOUND_FALSE,
        ]);
    }
}
