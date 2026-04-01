<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('tournaments');
            $table->foreignId('team_a')->constrained('tournament_registrations');
            $table->foreignId('team_b')->constrained('tournament_registrations');
            $table->foreignId('court_id')->constrained('courts');
            $table->json('team_a_score');
            $table->json('team_b_score');
            $table->string('serving_team');
            $table->integer('serving_player');
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
            $table->dateTime('scheduled_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
