<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MakeFormation extends Model
{
    protected $table = 'make_formation';

    protected $fillable = ['user_id', 'formation_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}