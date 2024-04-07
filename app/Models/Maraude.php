<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maraude extends Model
{
    use HasFactory;

    protected $table = 'maraude'; 
    
    protected $fillable = [
        'date',
        'ville'
    ];
}
