<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index()
    {
        return Tournament::all();
    }

    public function show($id)
    {
        return Tournament::findOrFail($id);
    }

    public function store(Request $request)
    {
        $tournament = Tournament::create($request->all());
        return response()->json($tournament, 201);
    }

    public function update(Request $request, $id)
    {
        $tournament = Tournament::findOrFail($id);
        $tournament->update($request->all());
        return response()->json($tournament);
    }

    public function destroy($id)
    {
        Tournament::destroy($id);
        return response()->json(null, 204);
    }
}
