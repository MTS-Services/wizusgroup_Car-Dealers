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
                'product_info_cat_type_id' => 1,
                'product_info_cat_type_feature_id' => 1, // Front Bumper
                'description' => 'Heavy-duty steel bumper with fog lamp slots.',
            ],
            [
                'product_id' => 1,
                'product_info_cat_id' => 2,
                'remarks' => 'Scratch resistant coating.',
            ],
            [
                'product_id' => 2,
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 1,
                'product_info_cat_type_feature_id' => 3, // Left Front Fender
                'description' => 'Fiber-reinforced plastic fender.',
            ],
            [
                'product_id' => 3,
                'product_info_cat_id' => 2,
                'remarks' => 'Slight wear on right corner.',
            ],
            [
                'product_id' => 4,
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 1,
                'product_info_cat_type_feature_id' => 2, // Bonnet
                'description' => 'Paint-matched bonnet with noise insulation.',
            ],
        ];


        foreach ($items as $item) {
            ProductInformation::create($item);
        }
    }
}
