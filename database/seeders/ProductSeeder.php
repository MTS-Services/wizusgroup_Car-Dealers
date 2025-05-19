<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Toyota Corolla 2020',
            'slug' => 'toyota-corolla-2020',
            'sku' => 'TC-2020-001',
            'stock_no' => 'STK001',
            'grade' => 'A',
            'body' => 'Sedan',
            'first_registration' => '2020-01-10',
            'type' => 'Gasoline',
            'displacement' => '1800cc',
            'specification_no' => 'SPEC-2020-A',
            'classification_no' => 'CLASS-A',
            'chassis_no' => 'CHS-123456789',
            'serial_no' => 'SRL-00112233',
            'capacity' => '5 Seater',
            'remarks' => 'Low mileage, single owner',
            'short_description' => 'Reliable and fuel-efficient sedan.',
            'description' => 'The 2020 Toyota Corolla offers an excellent combination of comfort and performance.',
            'price' => 18000.00,
            'cost_price' => 15000.00,
            'sale_price' => 17500.00,
            'quantity' => 12,
            'allow_backorder' => false,
            'supplier_id' => 1, // Assuming supplier with ID 1 exists
        ]);

        Product::create([
            'name' => 'Nissan Leaf EV 2021',
            'slug' => 'nissan-leaf-ev-2021',
            'sku' => 'NL-2021-002',
            'stock_no' => 'STK002',
            'grade' => 'A+',
            'body' => 'Hatchback',
            'first_registration' => '2021-05-15',
            'type' => 'Electric',
            'displacement' => null,
            'specification_no' => 'EV-LEAF-SPEC',
            'classification_no' => 'EV-CLASS',
            'chassis_no' => 'EV-CHS-8888999',
            'serial_no' => 'EV-SRL-445566',
            'capacity' => '5 Seater',
            'remarks' => 'Battery in great condition',
            'short_description' => 'Eco-friendly electric hatchback.',
            'description' => 'The 2021 Nissan Leaf offers top-notch EV performance and zero emissions.',
            'price' => 25000.00,
            'cost_price' => 21000.00,
            'sale_price' => 24000.00,
            'quantity' => 7,
            'allow_backorder' => true,
            'supplier_id' => 2, // Assuming supplier with ID 2 exists
        ]);

        Product::create([
            'name' => 'Honda CR-V 2019',
            'slug' => 'honda-crv-2019',
            'sku' => 'HCRV-2019-003',
            'stock_no' => 'STK003',
            'grade' => 'B+',
            'body' => 'SUV',
            'first_registration' => '2019-08-20',
            'type' => 'Diesel',
            'displacement' => '2000cc',
            'specification_no' => 'CRV-SPEC-2019',
            'classification_no' => 'CRV-CLASS',
            'chassis_no' => 'CHS-CRV-2019-8899',
            'serial_no' => 'SRL-998877',
            'capacity' => '7 Seater',
            'remarks' => 'Perfect for family trips.',
            'short_description' => 'Spacious and powerful SUV.',
            'description' => 'The 2019 Honda CR-V blends reliability with off-road capability.',
            'price' => 22000.00,
            'cost_price' => 18000.00,
            'sale_price' => 21000.00,
            'quantity' => 5,
            'allow_backorder' => false,
            'supplier_id' => 3, // Assuming supplier with ID 3 exists
        ]);
        Product::create([
            'name' => 'Yamaha R15 V4 2022',
            'slug' => 'yamaha-r15-v4-2022',
            'sku' => 'YR15V4-2022-004',
            'stock_no' => 'STK004',
            'grade' => 'A',
            'body' => 'Sport Bike',
            'first_registration' => '2022-03-12',
            'type' => 'Petrol',
            'displacement' => '155cc',
            'specification_no' => 'YR15-SPEC-V4',
            'classification_no' => 'BIKE-CLASS',
            'chassis_no' => 'BIKE-CHS-445522',
            'serial_no' => 'BIKE-SRL-778899',
            'capacity' => '2 Seater',
            'remarks' => 'Latest model with quick-shifter',
            'short_description' => 'Sleek, powerful and perfect for city rides.',
            'description' => 'The Yamaha R15 V4 2022 combines cutting-edge tech and sporty design for performance lovers.',
            'price' => 4500.00,
            'cost_price' => 3800.00,
            'sale_price' => 4300.00,
            'quantity' => 10,
            'allow_backorder' => true,
            'supplier_id' => 4, // Make sure supplier with ID 4 exists
        ]);
    }
}
