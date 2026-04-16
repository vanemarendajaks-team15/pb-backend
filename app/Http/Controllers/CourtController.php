<?php

namespace App\Http\Controllers;

use App\Models\Court;
use Illuminate\Http\Request;

class CourtController extends Controller
{
    public function index()
    {
        return Court::all();
    }

    public function show($id)
    {
        return Court::findOrFail($id);
    }

    public function store(Request $request)
    {
        $court = Court::create($request->all());
        return response()->json($court, 201);
    }

    public function update(Request $request, $id)
    {
        $court = Court::findOrFail($id);
        $court->update($request->all());
        return response()->json($court);
    }

    public function destroy($id)
    {
        Court::destroy($id);
        return response()->json(null, 204);
    }
}
