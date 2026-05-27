<?php

namespace Database\Factories;

use App\Models\Notebook;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotebookFactory extends Factory
{
    protected $model = Notebook::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(),
            'content' => fake()->text(200),
            'category' => fake()->randomElement(['Cá nhân', 'Công việc', 'Học tập']),
        ];
    }
}
