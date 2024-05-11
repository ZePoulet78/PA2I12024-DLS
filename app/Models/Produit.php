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
        'warehouse_id',
    ];

    public function entrepot()
    {
        return $this->belongsTo(Entrepot::class, 'warehouse_id');
    }

    public function maraudes()
    {
        return $this->belongsToMany(Maraude::class, 'maraude_produit', 'produit_id', 'maraude_id')->withPivot('quantity');
    }
}
