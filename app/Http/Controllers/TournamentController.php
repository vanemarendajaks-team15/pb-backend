<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TournamentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $today = Carbon::today();

        $query = Tournament::query()->withCount([
            'registrations as entries',
            'categories as categories',
        ]);

        if ($status === 'ended') {
            $query->whereDate('end_date', '<', $today);
        } elseif ($status === 'future') {
            $query->whereDate('start_date', '>', $today);
        } elseif ($status === 'live') {
            $query
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today);
        }

        return $this->withDefaultImage(
            $query->get()->makeHidden(['created_at', 'updated_at'])
        );
    }

    public function show($id)
    {
        $tournament = Tournament::withCount([
                'registrations as entries',
                'categories as categories',
            ])
            ->with([
                'games.court:id,court_name',
                'games.teamA:id,player1_id,player1_name,player2_id,player2_name',
                'games.teamA.player1:id,name',
                'games.teamA.player2:id,name',
                'games.teamB:id,player1_id,player1_name,player2_id,player2_name',
                'games.teamB.player1:id,name',
                'games.teamB.player2:id,name',
            ])
            ->findOrFail($id)
            ->makeHidden(['created_at', 'updated_at']);

        $tournament->setRelation('games', $tournament->games->map(function ($game) {
            return [
                'id' => $game->id,
                'courtName' => $game->court?->court_name,
                'tournamentId' => $game->tournament_id,
                'team1Player1Name' => $game->teamA?->player1?->name ?? $game->teamA?->player1_name,
                'team1Player2Name' => $game->teamA?->player2?->name ?? $game->teamA?->player2_name,
                'team2Player1Name' => $game->teamB?->player1?->name ?? $game->teamB?->player1_name,
                'team2Player2Name' => $game->teamB?->player2?->name ?? $game->teamB?->player2_name,
                'team1Score' => $game->team_a_score,
                'team2Score' => $game->team_b_score,
                'servingTeam' => $game->serving_team,
                'servingPlayer' => $game->serving_player,
                'status' => $game->status,
                'scheduledAt' => $game->scheduled_at?->format('Y-m-d H:i'),
            ];
        }));

        return $this->withDefaultImage($tournament);
    }

    public function store(Request $request)
    {
        $tournament = Tournament::create($request->all());

        return response()->json(
            $this->withDefaultImage(
                $tournament->loadCount([
                    'registrations as entries',
                    'categories as categories',
                ])->makeHidden(['created_at', 'updated_at'])
            ),
            201
        );
    }

    public function update(Request $request, $id)
    {
        $tournament = Tournament::findOrFail($id);
        $tournament->update($request->all());

        return response()->json(
            $this->withDefaultImage(
                $tournament->loadCount([
                    'registrations as entries',
                    'categories as categories',
                ])->makeHidden(['created_at', 'updated_at'])
            )
        );
    }

    public function destroy($id)
    {
        Tournament::destroy($id);
        return response()->json(null, 204);
    }

    private function withDefaultImage(Tournament|Collection $tournaments): Tournament|Collection
    {
        $defaultImage = Storage::url('images/poster.png');

        if ($tournaments instanceof Collection) {
            return $tournaments->each(function (Tournament $tournament) use ($defaultImage) {
                if ($tournament->image === null) {
                    $tournament->image = $defaultImage;
                }
            });
        }

        if ($tournaments->image === null) {
            $tournaments->image = $defaultImage;
        }

        return $tournaments;
    }
}
