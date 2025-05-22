<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            RoleHasPermissionSeeder::class,
            EmailTemplateSeeder::class,
            ApplicationSettingSeeder::class,

            CategorySeeder::class,
            SubCategorySeeder::class,
            SubChildCategorySeeder::class,

            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            OperationAreaSeeder::class,
            OperationSubAreaSeeder::class,

            BannerSeeder::class,
            AddressSeeder::class,
            FaqSeeder::class,
            CompanySeeder::class,
            BrandSeeder::class,
            ModelSeeder::class,
            PersonalInformationSeeder::class,

            TaxClassSeeder::class,
            TaxRateSeeder::class,

            SupplierSeeder::class,
            ProductInfoCategorySeeder::class,
            ProductInfoCategoryTypeSeeder::class,
            ProductInfoCategoryTypeFeatureSeeder::class,
            ProductAttributeSeeder::class,
            ProductSeeder::class,
            ProductRelationSeeder::class,
            ProductImageSeeder::class,
            ProductInformationSeeder::class,
            ProductAttributeValueSeeder::class,

            AuctionSeeder::class,
        ]);
    }
}
