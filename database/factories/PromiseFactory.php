<?php

namespace Database\Factories;

use App\Models\Promise;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromiseFactory extends Factory
{
    protected $model = Promise::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'promiser_name' => fake()->name(),
            'promise_content' => fake()->sentence(),
            'date_made' => fake()->date(),
            'deadline' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'status' => fake()->randomElement(['pending', 'completed', 'cancelled']),
            'importance_level' => fake()->numberBetween(1, 5),
        ];
    }
}
