<?php

namespace App\Http\Controllers;

use App\Models\TournamentRegistration;
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

    public function store(Request $request)
    {
        $registration = TournamentRegistration::create($request->all());
        return response()->json($registration, 201);
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
}
