<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'category_id' => 1, // Overwritten in seeder
            'name' => $this->faker->word(),
        ];
    }
}
