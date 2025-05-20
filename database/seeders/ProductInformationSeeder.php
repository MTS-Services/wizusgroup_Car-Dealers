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
                'remarks' => 'Reinforced for added protection.',
            ],
            [
                'product_id' => 1,
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 1,
                'product_info_cat_type_feature_id' => 2, // Bonnet
                'description' => 'Aerodynamic bonnet design for efficient airflow.',
                'remarks' => 'Scratch resistant coating.',
            ],
            [
                'product_id' => 2,
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 1,
                'product_info_cat_type_feature_id' => 3, // Left Front Fender
                'description' => 'Fiber-reinforced plastic fender.',
                'remarks' => 'No dents or cracks.',
            ],
            [
                'product_id' => 3,
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 1,
                'product_info_cat_type_feature_id' => 1, // Front Bumper
                'description' => 'Sleek design with integrated sensors.',
                'remarks' => 'Slight wear on right corner.',
            ],
            [
                'product_id' => 4,
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 1,
                'product_info_cat_type_feature_id' => 2, // Bonnet
                'description' => 'Paint-matched bonnet with noise insulation.',
                'remarks' => 'Minor touch-up needed on edge.',
            ],
        ];


        foreach ($items as $item) {
            ProductInformation::create($item);
        }
    }
}
