<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Court;
use App\Models\Tournament;

class CourtSeeder extends Seeder
{
    public function run(): void
    {
        $tournaments = Tournament::all();
        foreach ($tournaments as $tournament) {
            Court::factory()->count(2)->create([
                'tournament_id' => $tournament->id
            ]);
        }
    }
}
