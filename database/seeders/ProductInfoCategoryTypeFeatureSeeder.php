<?php
namespace Database\Seeders;

use App\Models\ProductInfoCategoryTypeFeature;
use Illuminate\Database\Seeder;

class ProductInfoCategoryTypeFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            // Main Damage - Situation of Damage (ID: 5)
            [
                'product_info_cat_id' => 1,
                'product_info_cat_type_id' => 5,
                'name' => 'Main Damage',
                'slug' => 'main-damage',
            ],
            [
                'product_info_cat_id' => 1,
                'product_info_cat_type_id' => 5,
                'name' => 'Area of Damage',
                'slug' => 'area-of-damage',
            ],
            [
                'product_info_cat_id' => 1,
                'product_info_cat_type_id' => 5,
                'name' => 'Drive Condition',
                'slug' => 'drive-condition',
            ],

            // Main Damage - Engine Room (ID: 6)
            [
                'product_info_cat_id' => 1,
                'product_info_cat_type_id' => 6,
                'name' => 'Engine (time of assessment)',
                'slug' => 'engine-time-of-assessment',
            ],
            [
                'product_info_cat_id' => 1,
                'product_info_cat_type_id' => 6,
                'name' => 'Shift Lever',
                'slug' => 'shift-lever',
            ],
            [
                'product_info_cat_id' => 1,
                'product_info_cat_type_id' => 6,
                'name' => 'Radiator & Condenser',
                'slug' => 'radiator-condenser',
            ],
            [
                'product_info_cat_id' => 1,
                'product_info_cat_type_id' => 6,
                'name' => 'Transmission Oil Pan',
                'slug' => 'transmission-oil-pan',
            ],
            [
                'product_info_cat_id' => 1,
                'product_info_cat_type_id' => 6,
                'name' => 'Oil Pan',
                'slug' => 'oil-pan',
            ],

            // Exterior Damage - Front (ID: 1)
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 1,
                'name' => 'Front Bumper',
                'slug' => 'front-bumper',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 1,
                'name' => 'Bonnet',
                'slug' => 'bonnet',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 1,
                'name' => 'Left Headlight',
                'slug' => 'left-headlight',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 1,
                'name' => 'Left Front Fender',
                'slug' => 'left-front-fender',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 1,
                'name' => 'Front Glass',
                'slug' => 'front-glass',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 1,
                'name' => 'Roof',
                'slug' => 'roof',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 1,
                'name' => 'Right Headlight',
                'slug' => 'right-headlight',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 1,
                'name' => 'Right Front Fender',
                'slug' => 'right-front-fender',
            ],

            // Exterior Damage - Side (ID: 2)
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 2,
                'name' => 'Left Front',
                'slug' => 'left-front',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 2,
                'name' => 'Left Rear Door',
                'slug' => 'left-rear-door',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 2,
                'name' => 'Left A Pillar',
                'slug' => 'left-a-pillar',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 2,
                'name' => 'Left B Pillar',
                'slug' => 'left-b-pillar',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 2,
                'name' => 'Left C Pillar',
                'slug' => 'left-c-pillar',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 2,
                'name' => 'Right Front Door',
                'slug' => 'right-front-door',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 2,
                'name' => 'Right Rear Door',
                'slug' => 'right-rear-door',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 2,
                'name' => 'Right A Pillar',
                'slug' => 'right-a-pillar',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 2,
                'name' => 'Right B Pillar',
                'slug' => 'right-b-pillar',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 2,
                'name' => 'Right C Pillar',
                'slug' => 'right-c-pillar',
            ],

            // Exterior Damage - Rear (ID: 3)
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 3,
                'name' => 'Left Rear Fender',
                'slug' => 'left-rear-fender',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 3,
                'name' => 'Taillight Left',
                'slug' => 'taillight-left',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 3,
                'name' => 'Rear Bumper',
                'slug' => 'rear-bumper',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 3,
                'name' => 'Trunk',
                'slug' => 'trunk',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 3,
                'name' => 'Right Rear Fender',
                'slug' => 'right-rear-fender',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 3,
                'name' => 'Taillight Right',
                'slug' => 'taillight-right',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 3,
                'name' => 'Rear Glass',
                'slug' => 'rear-glass',
            ],

            // Exterior Damage - Suspension (ID: 4)
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 4,
                'name' => 'Left Front Suspension',
                'slug' => 'left-front-suspension',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 4,
                'name' => 'Left Rear Suspension',
                'slug' => 'left-rear-suspension',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 4,
                'name' => 'Right Front Suspenstion',
                'slug' => 'right-front-suspenstion',
            ],
            [
                'product_info_cat_id' => 2,
                'product_info_cat_type_id' => 4,
                'name' => 'Right Rear Suspension',
                'slug' => 'right-rear-suspension',
            ],

            // Air Bag Equipment - Air-bag (ID: 7)
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 7,
                'name' => 'Passenger Seat',
                'slug' => 'passenger-seat',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 7,
                'name' => 'Seat(Passenger Side)',
                'slug' => 'seatpassenger-side',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 7,
                'name' => 'Passenger\'s Door',
                'slug' => 'passengers-door',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 7,
                'name' => 'Curtain(Passenger Side)',
                'slug' => 'curtainpassenger-side',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 7,
                'name' => 'Knee(Passenger Side)',
                'slug' => 'kneepassenger-side',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 7,
                'name' => 'Left Rear Seat Door',
                'slug' => 'left-rear-seat-door',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 7,
                'name' => 'Head',
                'slug' => 'head',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 7,
                'name' => 'Driver Seat',
                'slug' => 'driver-seat',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 7,
                'name' => 'Seat(Driver Side)',
                'slug' => 'seatdriver-side',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 7,
                'name' => 'Driver\'s Door',
                'slug' => 'drivers-door',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 7,
                'name' => 'Curtain(Driver Side)',
                'slug' => 'curtaindriver-side',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 7,
                'name' => 'Knee(Driver Side)',
                'slug' => 'kneedriver-side',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 7,
                'name' => 'Right Rear Seat Door',
                'slug' => 'right-rear-seat-door',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 7,
                'name' => 'Air bag · bonnet popup',
                'slug' => 'air-bag-bonnet-popup',
            ],

            // Air Bag Equipment - Equipment (ID: 8)
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 8,
                'name' => 'A/C',
                'slug' => 'ac',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 8,
                'name' => 'P/W',
                'slug' => 'pw',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 8,
                'name' => 'TV',
                'slug' => 'tv',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 8,
                'name' => 'Sunroof',
                'slug' => 'sunroof',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 8,
                'name' => 'Owner\'s Manual',
                'slug' => 'owners-manual',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 8,
                'name' => 'P/S',
                'slug' => 'ps',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 8,
                'name' => 'Navigation',
                'slug' => 'navigation',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 8,
                'name' => 'Leather Seat',
                'slug' => 'leather-seat',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 8,
                'name' => 'Maintenance Notebook',
                'slug' => 'maintenance-notebook',
            ],
            [
                'product_info_cat_id' => 3,
                'product_info_cat_type_id' => 8,
                'name' => 'Guarantee Form',
                'slug' => 'guarantee-form',
            ],

            // Other Info (category ID: 4, no type specified - NULL)
            [
                'product_info_cat_id' => 4,
                'product_info_cat_type_id' => null,
                'name' => 'Due in Place',
                'slug' => 'due-in-place',
            ],
            [
                'product_info_cat_id' => 4,
                'product_info_cat_type_id' => null,
                'name' => 'Due in Date',
                'slug' => 'due-in-date',
            ],
            [
                'product_info_cat_id' => 4,
                'product_info_cat_type_id' => null,
                'name' => 'Estimated Arrival Date',
                'slug' => 'estimated-arrival-date',
            ],
            [
                'product_info_cat_id' => 4,
                'product_info_cat_type_id' => null,
                'name' => 'De-Registration Certificate',
                'slug' => 'de-registration-certificate',
            ],
            [
                'product_info_cat_id' => 4,
                'product_info_cat_type_id' => null,
                'name' => 'Inspection Period',
                'slug' => 'inspection-period',
            ],
            [
                'product_info_cat_id' => 4,
                'product_info_cat_type_id' => null,
                'name' => 'Recycling Fee',
                'slug' => 'recycling-fee',
            ],
            [
                'product_info_cat_id' => 4,
                'product_info_cat_type_id' => null,
                'name' => 'Length',
                'slug' => 'length',
            ],
            [
                'product_info_cat_id' => 4,
                'product_info_cat_type_id' => null,
                'name' => 'Width',
                'slug' => 'width',
            ],
            [
                'product_info_cat_id' => 4,
                'product_info_cat_type_id' => null,
                'name' => 'Height',
                'slug' => 'height',
            ],
            [
                'product_info_cat_id' => 4,
                'product_info_cat_type_id' => null,
                'name' => 'Maximum Loading Weight',
                'slug' => 'maximum-loading-weight',
            ],
            [
                'product_info_cat_id' => 4,
                'product_info_cat_type_id' => null,
                'name' => 'Unit Weight',
                'slug' => 'unit-weight',
            ],
            [
                'product_info_cat_id' => 4,
                'product_info_cat_type_id' => null,
                'name' => 'Gross Unit Weight',
                'slug' => 'gross-unit-weight',
            ],
        ];

        foreach ($features as $feature) {
            ProductInfoCategoryTypeFeature::create($feature);
        }
    }
}