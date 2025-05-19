<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::create([
            'question' => 'What is the warranty period for vehicles?',
            'answer' => 'Most vehicles come with a 6-month standard warranty. Please check the product details for specific warranty coverage.',
            'type' => Faq::TYPE_PRODUCT,
        ]);

        Faq::create([
            'question' => 'Can I see the maintenance history of the equipment?',
            'answer' => 'Yes, maintenance records are available for most products. You can request them via the contact form on the product page.',
            'type' => Faq::TYPE_PRODUCT,
        ]);

        Faq::create([
            'question' => 'Are spare parts available for all listed machines?',
            'answer' => 'We ensure spare parts availability for all major brands and models listed on our platform.',
            'type' => Faq::TYPE_PRODUCT,
        ]);

        Faq::create([
            'question' => 'Do the listed prices include shipping?',
            'answer' => 'Shipping costs are calculated separately based on location and delivery preferences. Contact support for a detailed quote.',
            'type' => Faq::TYPE_PRODUCT,
        ]);
    }
}
