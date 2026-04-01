<?php

namespace Database\Factories;

use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

class TournamentFactory extends Factory
{
    protected $model = Tournament::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'location' => $this->faker->city(),
            'start_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+2 days', '+2 months'),
            'description' => $this->faker->sentence(),
            'director_id' => 1, // You may want to seed users first and randomize this
        ];
    }
}
