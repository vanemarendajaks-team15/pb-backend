<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TournamentManagerController;
use App\Http\Controllers\TournamentRegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('v1/tournaments', [TournamentController::class, 'index'])
    ->whereIn('status', ['ended', 'future', 'live']);
Route::get('v1/tournaments/{tournament}', [TournamentController::class, 'show']);
Route::get('v1/games/{game}', [GameController::class, 'show']);

Route::apiResource('v1/tournaments', TournamentController::class);
Route::apiResource('v1/categories', CategoryController::class);
Route::apiResource('v1/tournament-registrations', TournamentRegistrationController::class);
Route::apiResource('v1/groups', GroupController::class);
Route::apiResource('v1/courts', CourtController::class);
Route::apiResource('v1/games', GameController::class);
Route::apiResource('v1/tournament-managers', TournamentManagerController::class);
