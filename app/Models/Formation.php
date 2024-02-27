<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Migrations\Migrations;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Formation extends Model
{
    use HasFactory;

    // protected $primaryKey = 'id_formation'; // Définir la clé primaire personnalisée
    protected $fillable = ['nom', 'time', 'but', 'description', 'lieu']; // Attributs remplissables
}