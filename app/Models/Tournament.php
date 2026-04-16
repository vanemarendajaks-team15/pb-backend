<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Court;
use App\Models\TournamentManager;
use App\Models\TournamentRegistration;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'start_date', 'end_date', 'image', 'description', 'director_id'
    ];

    public function director()
    {
        return $this->belongsTo(User::class, 'director_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function courts()
    {
        return $this->hasMany(Court::class);
    }

    public function managers()
    {
        return $this->hasMany(TournamentManager::class);
    }

    public function registrations()
    {
        return $this->hasMany(TournamentRegistration::class);
    }
}
