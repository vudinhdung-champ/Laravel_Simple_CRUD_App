<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'service_name' => fake()->company(),
            'price' => fake()->numberBetween(100, 10000),
            'billing_cycle' => fake()->randomElement(['monthly', 'yearly', 'weekly']),
            'next_billing_date' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'status' => fake()->randomElement(['active', 'inactive', 'cancelled']),
            'color_code' => fake()->hexColor(),
            'notes' => fake()->sentence(),
        ];
    }
}
