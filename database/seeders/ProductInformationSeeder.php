<?php

namespace Database\Seeders;

use App\Models\ProductInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'product_id' => 1,
                'product_info_cat_id' => 2,
                'description' => 'Heavy-duty steel bumper with fog lamp slots.',
            ],
            [
                'product_id' => 1,
                'product_info_cat_id' => 2,
                'description' => 'Scratch resistant coating.',
            ],
            [
                'product_id' => 2,
                'product_info_cat_id' => 2,
                'description' => 'Fiber-reinforced plastic fender.',
            ],
            [
                'product_id' => 3,
                'product_info_cat_id' => 2,
                'description' => 'Slight wear on right corner.',
            ],
            [
                'product_id' => 4,
                'product_info_cat_id' => 2,
                'description' => 'Paint-matched bonnet with noise insulation.',
            ],
        ];


        foreach ($items as $item) {
            ProductInformation::create($item);
        }
    }
}
