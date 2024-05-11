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
    ];
}

// ajouter l'user id