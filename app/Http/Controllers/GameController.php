<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\TournamentRegistration;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with([
            'tournament:id,name',
            'court:id,court_name',
            'teamA:id,player1_name,player2_name,player1_id,player2_id',
            'teamA.player1:id,name',
            'teamA.player2:id,name',
            'teamB:id,player1_name,player2_name,player1_id,player2_id',
            'teamB.player1:id,name',
            'teamB.player2:id,name',
        ])->get();

        return $games->map(fn (Game $game) => $this->transformGame($game));
    }

    public function show($id)
    {
        $game = Game::with([
            'tournament:id,name',
            'court:id,court_name',
            'teamA:id,player1_name,player2_name,player1_id,player2_id',
            'teamA.player1:id,name',
            'teamA.player2:id,name',
            'teamB:id,player1_name,player2_name,player1_id,player2_id',
            'teamB.player1:id,name',
            'teamB.player2:id,name',
        ])->findOrFail($id);

        return $this->transformGame($game);
    }

    public function store(Request $request)
    {
        $game = Game::create($request->all());

        $game->load([
            'tournament:id,name',
            'court:id,court_name',
            'teamA:id,player1_name,player2_name,player1_id,player2_id',
            'teamA.player1:id,name',
            'teamA.player2:id,name',
            'teamB:id,player1_name,player2_name,player1_id,player2_id',
            'teamB.player1:id,name',
            'teamB.player2:id,name',
        ]);

        return response()->json($this->transformGame($game), 201);
    }

    public function update(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        $game->update($request->all());

        $game->load([
            'tournament:id,name',
            'court:id,court_name',
            'teamA:id,player1_name,player2_name,player1_id,player2_id',
            'teamA.player1:id,name',
            'teamA.player2:id,name',
            'teamB:id,player1_name,player2_name,player1_id,player2_id',
            'teamB.player1:id,name',
            'teamB.player2:id,name',
        ]);

        return response()->json($this->transformGame($game));
    }

    public function destroy($id)
    {
        Game::destroy($id);
        return response()->json(null, 204);
    }

    private function transformGame(Game $game): array
    {
        return [
            'id' => $game->id,
            'tournamentId' => $game->tournament_id,
            'tournamentName' => $game->tournament?->name,
            'courtName' => $game->court?->court_name,
            'team1Player1Name' => $this->resolvePlayerName($game->teamA, 1),
            'team1Player2Name' => $this->resolvePlayerName($game->teamA, 2),
            'team2Player1Name' => $this->resolvePlayerName($game->teamB, 1),
            'team2Player2Name' => $this->resolvePlayerName($game->teamB, 2),
            'team1Score' => $game->team_a_score,
            'team2Score' => $game->team_b_score,
            'servingTeam' => $game->serving_team,
            'servingPlayer' => $game->serving_player,
        ];
    }

    private function resolvePlayerName(?TournamentRegistration $team, int $playerIndex): ?string
    {
        if ($team === null) {
            return null;
        }

        if ($playerIndex === 1) {
            return $team->player1_name ?? $team->player1?->name;
        }

        return $team->player2_name ?? $team->player2?->name;
    }
}
