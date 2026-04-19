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

        $defaultImage = Storage::url('images/poster.png');

        $tournaments = $query->get()->map(function ($tournament) use ($defaultImage) {
            return [
                'id' => $tournament->id,
                'name' => $tournament->name,
                'location' => $tournament->location,
                'description' => $tournament->description,
                'image' => $tournament->image ?? $defaultImage,
                'startDate' => Carbon::parse($tournament->start_date)->format('d.m.Y'),
                'endDate' => Carbon::parse($tournament->end_date)->format('d.m.Y'),
                'directorId' => $tournament->director_id,
                'entries' => $tournament->entries,
                'categories' => $tournament->categories,
            ];
        });

        return response()->json($tournaments);
    }

    public function show($id)
    {
        return $this->withDefaultImage(
            Tournament::withCount([
                'registrations as entries',
                'categories as categories',
            ])->findOrFail($id)->makeHidden(['created_at', 'updated_at'])
        );
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
