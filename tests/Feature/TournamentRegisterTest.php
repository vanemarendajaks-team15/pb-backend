<?php

namespace Tests\Feature;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_tournament_can_be_registered(): void
    {
        $director = User::factory()->create();

        $payload = [
            'data' => [
                'name' => 'Kevadturniir 2026',
                'location' => 'Tallinn',
                'startDate' => '2026-05-10',
                'endDate' => '2026-05-12',
                'posterReference' => 'poster.png',
                'description' => 'Testturniir',
                'directorId' => $director->id,
            ],
        ];

        $response = $this->postJson('/api/v1/tournament/register', $payload);

        $response
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseHas('tournaments', [
            'id' => $response->json('id'),
            'name' => 'Kevadturniir 2026',
            'location' => 'Tallinn',
            'image' => 'poster.png',
            'description' => 'Testturniir',
            'director_id' => $director->id,
        ]);

        $this->assertSame(1, Tournament::count());
    }

    public function test_tournament_registration_requires_existing_director(): void
    {
        $payload = [
            'data' => [
                'name' => 'Kevadturniir 2026',
                'location' => 'Tallinn',
                'startDate' => '2026-05-10',
                'endDate' => '2026-05-12',
                'posterReference' => 'poster.png',
                'description' => 'Testturniir',
                'directorId' => 999999,
            ],
        ];

        $response = $this->postJson('/api/v1/tournament/register', $payload);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['data.directorId']);

        $this->assertDatabaseCount('tournaments', 0);
    }
}
