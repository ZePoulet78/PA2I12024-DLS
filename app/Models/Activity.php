<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    protected $table = 'activity';

    protected $fillable = [
        'heure_debut',
        'heure_fin',
        'date',
        'type',
        'description',
        'user_id',
        'lieu',
        'max_users',
        'actual_users'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function makeActivity()
    {
        return $this->hasMany(MakeActivity::class);
    }
}