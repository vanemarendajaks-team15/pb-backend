<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id', 'court_name'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
