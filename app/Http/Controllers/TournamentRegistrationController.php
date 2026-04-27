<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTournamentRegistrationRequest;
use App\Models\Tournament;
use App\Models\TournamentRegistration;
use App\Models\User;
use Illuminate\Http\Request;

class TournamentRegistrationController extends Controller
{
    public function index()
    {
        return TournamentRegistration::all();
    }

    public function show($id)
    {
        return TournamentRegistration::findOrFail($id);
    }

    public function store(StoreTournamentRegistrationRequest $request, Tournament $tournament)
    {
        $player1 = User::query()->where('email', $request->string('player1_email'))->firstOrFail();
        $player2 = User::query()->where('email', $request->string('player2_email'))->firstOrFail();

        $alreadyRegistered = TournamentRegistration::query()
            ->where('tournament_id', $tournament->id)
            ->where('category_id', $request->integer('category_id'))
            ->where(function ($query) use ($player1, $player2) {
                $query
                    ->where('player1_id', $player1->id)
                    ->where('player2_id', $player2->id)
                    ->orWhere(function ($reversedQuery) use ($player1, $player2) {
                        $reversedQuery
                            ->where('player1_id', $player2->id)
                            ->where('player2_id', $player1->id);
                    });
            })
            ->exists();

        if ($alreadyRegistered) {
            return response()->json([
                'message' => 'This pair is already registered in the selected category.',
                'errors' => [
                    'pair' => ['This pair is already registered in the selected category.'],
                ],
            ], 422);
        }

        $registration = TournamentRegistration::create([
            'tournament_id' => $tournament->id,
            'category_id' => $request->integer('category_id'),
            'player1_id' => $player1->id,
            'player1_name' => $player1->name,
            'player2_id' => $player2->id,
            'player2_name' => $player2->name,
        ]);

        return response()->json($this->formatRegistrationResponse($registration), 201);
    }

    public function update(Request $request, $id)
    {
        $registration = TournamentRegistration::findOrFail($id);
        $registration->update($request->all());
        return response()->json($registration);
    }

    public function destroy($id)
    {
        TournamentRegistration::destroy($id);
        return response()->json(null, 204);
    }

    protected function formatRegistrationResponse(TournamentRegistration $registration): array
    {
        $registration->loadMissing(['tournament', 'category', 'player1', 'player2']);

        return [
            'id' => $registration->id,
            'tournament' => [
                'id' => $registration->tournament_id,
                'name' => $registration->tournament?->name,
            ],
            'category' => [
                'id' => $registration->category_id,
                'name' => $registration->category?->name,
            ],
            'players' => [
                [
                    'id' => $registration->player1_id,
                    'name' => $registration->player1_name,
                    'email' => $registration->player1?->email,
                ],
                [
                    'id' => $registration->player2_id,
                    'name' => $registration->player2_name,
                    'email' => $registration->player2?->email,
                ],
            ],
        ];
    }
}
