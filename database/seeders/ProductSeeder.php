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
            'name' => 'John Deere 5075E Tractor',
            'slug' => 'john-deere-5075e-tractor',
            'sku' => 'JD-5075E-001',
            'stock_no' => 'TRK001',
            'grade' => 'A',
            'body' => 'Utility Tractor',
            'first_registration' => '2021-03-15',
            'type' => 'Diesel',
            'displacement' => '2900cc',
            'specification_no' => 'JD5075E-SPEC',
            'classification_no' => 'AGRI-TRACTOR',
            'chassis_no' => 'JD-CH-5075E-2021',
            'serial_no' => 'JD-SRL-5075E-01',
            'capacity' => '2 Seater',
            'remarks' => 'Well-maintained, low hours',
            'short_description' => 'Reliable utility tractor with 75HP engine.',
            'description' => 'The John Deere 5075E is known for its durability, comfort, and fuel-efficient engine—perfect for small to medium farms.',
            'price' => 32000.00,
            'cost_price' => 27000.00,
            'sale_price' => 31000.00,
            'quantity' => 3,
            'allow_backorder' => false,
            'supplier_id' => 1,
        ]);

        Product::create([
            'name' => 'Caterpillar 320 Excavator',
            'slug' => 'caterpillar-320-excavator',
            'sku' => 'CAT-320-002',
            'stock_no' => 'EXC002',
            'grade' => 'B+',
            'body' => 'Excavator',
            'first_registration' => '2019-07-25',
            'type' => 'Diesel',
            'displacement' => '7200cc',
            'specification_no' => 'CAT320-SPEC',
            'classification_no' => 'CONSTRUCTION-EQ',
            'chassis_no' => 'CAT-CH-320-2019',
            'serial_no' => 'CAT-SRL-320-2019',
            'capacity' => 'Operator Cabin',
            'remarks' => 'Heavy-duty usage with recent maintenance',
            'short_description' => 'Versatile excavator ideal for construction sites.',
            'description' => 'The Caterpillar 320 is a mid-size excavator built for strength, fuel efficiency, and operator comfort.',
            'price' => 145000.00,
            'cost_price' => 125000.00,
            'sale_price' => 140000.00,
            'quantity' => 2,
            'allow_backorder' => false,
            'supplier_id' => 2,
        ]);

        Product::create([
            'name' => 'Toyota Hilux 2022',
            'slug' => 'toyota-hilux-2022',
            'sku' => 'THX-2022-003',
            'stock_no' => 'PCK003',
            'grade' => 'A+',
            'body' => 'Pickup Truck',
            'first_registration' => '2022-05-10',
            'type' => 'Diesel',
            'displacement' => '2800cc',
            'specification_no' => 'HILUX-SPEC-2022',
            'classification_no' => 'VEHICLE-PICKUP',
            'chassis_no' => 'TOY-HILUX-2022-001',
            'serial_no' => 'SRL-HILUX-2022-003',
            'capacity' => '5 Seater',
            'remarks' => 'Top trim with 4x4 drivetrain',
            'short_description' => 'Durable and powerful pickup for all terrains.',
            'description' => 'The 2022 Toyota Hilux features advanced safety, luxury interior, and strong towing capability.',
            'price' => 40000.00,
            'cost_price' => 35000.00,
            'sale_price' => 39000.00,
            'quantity' => 4,
            'allow_backorder' => false,
            'supplier_id' => 3,
        ]);

        Product::create([
            'name' => 'Massey Ferguson 135',
            'slug' => 'massey-ferguson-135',
            'sku' => 'MF-135-004',
            'stock_no' => 'TRK004',
            'grade' => 'B',
            'body' => 'Tractor',
            'first_registration' => '2018-11-12',
            'type' => 'Diesel',
            'displacement' => '2500cc',
            'specification_no' => 'MF135-SPEC',
            'classification_no' => 'AGRI-TRACTOR',
            'chassis_no' => 'MF-CH-135-2018',
            'serial_no' => 'MF-SRL-135-004',
            'capacity' => '1 Seater',
            'remarks' => 'Classic model, robust engine',
            'short_description' => 'Iconic compact tractor for all-purpose use.',
            'description' => 'The Massey Ferguson 135 is a time-tested favorite among small-scale farmers for its reliability and ease of maintenance.',
            'price' => 12000.00,
            'cost_price' => 9500.00,
            'sale_price' => 11500.00,
            'quantity' => 6,
            'allow_backorder' => true,
            'supplier_id' => 1,
        ]);

        Product::create([
            'name' => 'Renault Master Van 2020',
            'slug' => 'renault-master-van-2020',
            'sku' => 'RMV-2020-005',
            'stock_no' => 'VAN005',
            'grade' => 'A',
            'body' => 'Van',
            'first_registration' => '2020-02-05',
            'type' => 'Diesel',
            'displacement' => '2300cc',
            'specification_no' => 'RMV-SPEC-2020',
            'classification_no' => 'COMMERCIAL-VAN',
            'chassis_no' => 'RENAULT-MST-2020',
            'serial_no' => 'SRL-MST-2020-005',
            'capacity' => '3 Seater + Cargo',
            'remarks' => 'Great for commercial delivery use',
            'short_description' => 'Spacious and efficient commercial van.',
            'description' => 'The Renault Master 2020 offers excellent load capacity and a smooth drive, making it ideal for logistics and transport.',
            'price' => 28000.00,
            'cost_price' => 23000.00,
            'sale_price' => 27000.00,
            'quantity' => 8,
            'allow_backorder' => false,
            'supplier_id' => 2,
        ]);
    }
}
