<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $models = [
            ['name' => '5055E',       'slug' => '5055e',        'brand_id' => 1],
            ['name' => 'Arjun Novo',  'slug' => 'arjun-novo',   'brand_id' => 2],
            ['name' => 'MF 241 DI',   'slug' => 'mf-241-di',    'brand_id' => 3],
            ['name' => 'Excel 4710',  'slug' => 'excel-4710',   'brand_id' => 4],
            ['name' => 'L4508',       'slug' => 'l4508',        'brand_id' => 5],
            ['name' => 'DI 750 III',  'slug' => 'di-750-iii',   'brand_id' => 6],
            ['name' => 'Agrolux 70',  'slug' => 'agrolux-70',   'brand_id' => 7],
            ['name' => 'Corolla',     'slug' => 'corolla',      'brand_id' => 8],
            ['name' => 'Civic',       'slug' => 'civic',        'brand_id' => 9],
            ['name' => 'Mustang',     'slug' => 'mustang',      'brand_id' => 10],
            ['name' => '3 Series',    'slug' => '3-series',     'brand_id' => 11],
            ['name' => 'E-Class',     'slug' => 'e-class',      'brand_id' => 12],
            ['name' => 'Elantra',     'slug' => 'elantra',      'brand_id' => 13],
            ['name' => 'Altima',      'slug' => 'altima',       'brand_id' => 14],
            ['name' => 'Passat',      'slug' => 'passat',       'brand_id' => 15],
        ];

        foreach ($models as $item) {
            $brand = Brand::findOrFail($item['brand_id']);

            Model::create([
                'name' => $item['name'],
                'slug' => $item['slug'],
                'brand_id' => $item['brand_id'],
                'company_id' => $brand->company_id,
            ]);
        }
    }
}
