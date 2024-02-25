<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $table = 'demande';
    
    protected $fillable = [
        'email',
        'password',
        'role',
        'firstname',
        'lastname',
        'avatar',
        'tel',
    ];
}
