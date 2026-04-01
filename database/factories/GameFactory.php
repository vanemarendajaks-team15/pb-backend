<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        return [
            'tournament_id' => 1, // Overwritten in seeder
            'team_a' => 1, // Overwritten in seeder
            'team_b' => 2, // Overwritten in seeder
            'court_id' => 1, // Overwritten in seeder
            'team_a_score' => [rand(0, 21), rand(0, 21)],
            'team_b_score' => [rand(0, 21), rand(0, 21)],
            'serving_team' => $this->faker->randomElement(['A', 'B']),
            'serving_player' => $this->faker->numberBetween(1, 2),
            'status' => $this->faker->randomElement(['scheduled', 'in_progress', 'completed', 'cancelled']),
            'scheduled_at' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
        ];
    }
}
