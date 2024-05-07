<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'ticket_id'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}