<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MakeMaraude extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'maraude_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function maraude()
    {
        return $this->belongsTo(Maraude::class);
    }
}
