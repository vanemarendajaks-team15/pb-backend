<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tournament_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('tournaments');
            $table->foreignId('player1_id')->nullable()->constrained('users');
            $table->string('player1_name')->nullable();
            $table->foreignId('player2_id')->nullable()->constrained('users');
            $table->string('player2_name')->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_registrations');
    }
};
