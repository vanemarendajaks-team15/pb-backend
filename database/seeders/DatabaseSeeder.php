<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\TournamentSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\TournamentRegistrationSeeder;
use Database\Seeders\GroupSeeder;
use Database\Seeders\CourtSeeder;
use Database\Seeders\GameSeeder;
use Database\Seeders\TournamentManagerSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TournamentSeeder::class,
            CategorySeeder::class,
            TournamentRegistrationSeeder::class,
            GroupSeeder::class,
            CourtSeeder::class,
            GameSeeder::class,
            TournamentManagerSeeder::class,
        ]);

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
