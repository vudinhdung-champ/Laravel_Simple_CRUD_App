<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Notebook;
use App\Models\Promise;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['username' => 'Test User', 'password' => bcrypt('password')]
        );

        Notebook::factory(100)->create(['user_id' => $user->id]);
        Promise::factory(100)->create(['user_id' => $user->id]);
        Subscription::factory(100)->create(['user_id' => $user->id]);
    }
}
