<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

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

        $tournaments = $query->get()->map(function ($tournament) {
            return [
                'id' => $tournament->id,
                'name' => $tournament->name,
                'location' => $tournament->location,
                'description' => $tournament->description,
                'image' => $tournament->image,
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
        return Tournament::withCount([
            'registrations as entries',
            'categories as categories',
        ])->findOrFail($id)->makeHidden(['created_at', 'updated_at']);
    }

    public function store(Request $request)
    {
        $tournament = Tournament::create($request->all());

        return response()->json(
            $tournament->loadCount([
                'registrations as entries',
                'categories as categories',
            ])->makeHidden(['created_at', 'updated_at']),
            201
        );
    }

    public function update(Request $request, $id)
    {
        $tournament = Tournament::findOrFail($id);
        $tournament->update($request->all());

        return response()->json(
            $tournament->loadCount([
                'registrations as entries',
                'categories as categories',
            ])->makeHidden(['created_at', 'updated_at'])
        );
    }

    public function destroy($id)
    {
        Tournament::destroy($id);
        return response()->json(null, 204);
    }
}
