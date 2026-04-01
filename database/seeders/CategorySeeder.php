<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Tournament;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $tournaments = Tournament::all();
        foreach ($tournaments as $tournament) {
            Category::factory()->count(2)->create([
                'tournament_id' => $tournament->id
            ]);
        }
    }
}
