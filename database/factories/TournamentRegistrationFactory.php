<?php

namespace Database\Factories;

use App\Models\TournamentRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;

class TournamentRegistrationFactory extends Factory
{
    protected $model = TournamentRegistration::class;

    public function definition(): array
    {
        return [
            'tournament_id' => 1, // Overwritten in seeder
            'player1_id' => 1, // Overwritten in seeder
            'player1_name' => $this->faker->name(),
            'player2_id' => 2, // Overwritten in seeder
            'player2_name' => $this->faker->name(),
            'category_id' => 1, // Overwritten in seeder
        ];
    }
}
