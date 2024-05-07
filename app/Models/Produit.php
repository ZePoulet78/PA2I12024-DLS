<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produit';

    protected $fillable = [
        'name',
        'quantity',
        'expiration_date',
        'id_entrepot',
    ];

    public function entrepot()
    {
        return $this->belongsTo(Entrepot::class, 'id_entrepot');
    }
}
