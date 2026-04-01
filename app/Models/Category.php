<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id', 'name'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
