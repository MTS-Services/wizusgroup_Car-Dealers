<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => $this->faker->sentence(),
            'answer' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement([Faq::STATUS_ACTIVE, Faq::STATUS_DEACTIVE]),
            'type' => $this->faker->randomElement([Faq::TYPE_ABOUT, Faq::TYPE_CONTACT, Faq::TYPE_GENERAL, Faq::TYPE_PRIVACY, Faq::TYPE_PRODUCT, Faq::TYPE_TERMS]),
        ];
    }
}
