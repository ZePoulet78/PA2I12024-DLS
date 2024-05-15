<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    protected $fillable = [
        'date',
        'id_vehicule',
        'id_user',
        'plan_de_route',
    ];
}
