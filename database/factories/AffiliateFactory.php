<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Affiliate>
 */
class AffiliateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'=>$this->faker->numberBetween(1,10),
            'merchant_id'=>$this->faker->numberBetween(1,10),
            'discount_code' => $this->faker->uuid(),
            'commission_rate' => round(rand(1, 5) / 10, 1)
        ];
    }
}
