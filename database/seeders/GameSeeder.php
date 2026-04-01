<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Tournament;
use App\Models\Court;
use App\Models\TournamentRegistration;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $tournaments = Tournament::all();
        foreach ($tournaments as $tournament) {
            $courts = $tournament->courts;
            $registrations = $tournament->registrations ?? [];
            if ($registrations->count() < 2) continue;
            foreach ($courts as $court) {
                Game::factory()->count(2)->create([
                    'tournament_id' => $tournament->id,
                    'court_id' => $court->id,
                    'team_a' => $registrations->random()->id,
                    'team_b' => $registrations->random()->id,
                ]);
            }
        }
    }
}
