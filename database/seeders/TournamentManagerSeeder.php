<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TournamentManager;
use App\Models\Tournament;
use App\Models\User;

class TournamentManagerSeeder extends Seeder
{
    public function run(): void
    {
        $tournaments = Tournament::all();
        $users = User::all();
        foreach ($tournaments as $tournament) {
            TournamentManager::factory()->count(2)->create([
                'tournament_id' => $tournament->id,
                'user_id' => $users->random()->id,
            ]);
        }
    }
}
