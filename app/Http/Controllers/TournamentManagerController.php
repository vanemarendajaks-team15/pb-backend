<?php

namespace App\Http\Controllers;

use App\Models\TournamentManager;
use Illuminate\Http\Request;

class TournamentManagerController extends Controller
{
    public function index()
    {
        return TournamentManager::all();
    }

    public function show($id)
    {
        return TournamentManager::findOrFail($id);
    }

    public function store(Request $request)
    {
        $manager = TournamentManager::create($request->all());
        return response()->json($manager, 201);
    }

    public function update(Request $request, $id)
    {
        $manager = TournamentManager::findOrFail($id);
        $manager->update($request->all());
        return response()->json($manager);
    }

    public function destroy($id)
    {
        TournamentManager::destroy($id);
        return response()->json(null, 204);
    }
}
