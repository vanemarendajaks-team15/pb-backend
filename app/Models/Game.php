<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id', 'team_a', 'team_b', 'court_id', 'team_a_score', 'team_b_score', 'serving_team', 'serving_player', 'status', 'scheduled_at'
    ];

    protected $casts = [
        'team_a_score' => 'array',
        'team_b_score' => 'array',
        'scheduled_at' => 'datetime',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function teamA()
    {
        return $this->belongsTo(TournamentRegistration::class, 'team_a');
    }

    public function teamB()
    {
        return $this->belongsTo(TournamentRegistration::class, 'team_b');
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}
