<?php

namespace Database\Factories;

use App\Models\TournamentManager;
use Illuminate\Database\Eloquent\Factories\Factory;

class TournamentManagerFactory extends Factory
{
    protected $model = TournamentManager::class;

    public function definition(): array
    {
        return [
            'tournament_id' => 1, // Overwritten in seeder
            'user_id' => 1, // Overwritten in seeder
            'role' => $this->faker->randomElement(['admin', 'referee', 'organizer']),
        ];
    }
}
