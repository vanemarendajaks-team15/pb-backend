<?php

namespace Database\Factories;

use App\Models\Court;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourtFactory extends Factory
{
    protected $model = Court::class;

    public function definition(): array
    {
        return [
            'tournament_id' => 1, // Overwritten in seeder
            'court_name' => 'Court ' . $this->faker->numberBetween(1, 10),
        ];
    }
}
