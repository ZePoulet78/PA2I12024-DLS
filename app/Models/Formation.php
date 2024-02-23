<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_formation'; // Définir la clé primaire personnalisée
    protected $fillable = ['nom', 'time', 'but', 'description', 'lieu']; // Attributs remplissables
}
