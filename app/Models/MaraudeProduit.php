<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MaraudeProduit extends Pivot
{
    protected $table = 'maraude_produit';

    protected $fillable = [
        'maraude_id',
        'produit_id',
        'quantity',
    ];
}