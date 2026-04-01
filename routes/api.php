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

Route::apiResource('tournaments', TournamentController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('tournament-registrations', TournamentRegistrationController::class);
Route::apiResource('groups', GroupController::class);
Route::apiResource('courts', CourtController::class);
Route::apiResource('games', GameController::class);
Route::apiResource('tournament-managers', TournamentManagerController::class);
