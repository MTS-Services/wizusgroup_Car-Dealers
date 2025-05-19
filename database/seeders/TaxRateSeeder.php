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
            'tax_class_id' => 1,
            'country_id' => 1,
            'state_id' => NULL,
            'city_id'=> 2,
            'rate'=>15.00,
            'name' => 'National Standard',
            'priority' => TaxRate::PRIORITY_HIGH,
            'compound' => TaxRate::COMPOUND_FALSE,
        ]);
        TaxRate::create([
            'tax_class_id' => 1,
            'country_id' => 4,
            'state_id' => 1,
            'city_id'=> 1,
            'rate'=>15.00,
            'name' => 'City Surcharge',
            'priority' => TaxRate::PRIORITY_LOW,
            'compound' => TaxRate::COMPOUND_TRUE,
        ]);
        TaxRate::create([
            'tax_class_id' => 2,
            'country_id' => 4,
            'state_id' => 2,
            'city_id'=> NULL,
            'rate'=>25.00,
            'name' => 'State Add-on',
            'priority' => TaxRate::PRIORITY_URGENT,
            'compound' => TaxRate::COMPOUND_FALSE,
        ]);
        TaxRate::create([
            'tax_class_id' => 1,
            'country_id' => 4,
            'state_id' => 3,
            'city_id'=> NULL,
            'rate'=>5.00,
            'name' => 'State Add-on',
            'priority' => TaxRate::PRIORITY_NORMAL,
            'compound' => TaxRate::COMPOUND_FALSE,
        ]);
    }
}
