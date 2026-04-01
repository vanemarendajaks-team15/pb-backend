<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TournamentRegistration;
use App\Models\Tournament;
use App\Models\Category;
use App\Models\User;

class TournamentRegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $users = User::all();
        foreach ($categories as $category) {
            TournamentRegistration::factory()->count(4)->create([
                'tournament_id' => $category->tournament_id,
                'category_id' => $category->id,
                'player1_id' => $users->random()->id,
                'player2_id' => $users->random()->id,
            ]);
        }
    }
}
