<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maraude extends Model
{
    use HasFactory;

    protected $table = 'maraude'; 
    
    protected $fillable = [
        'maraud_date',
        'departure_time',
        'return_time',
        'itinerary',
    ];

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'maraude_produit', 'maraude_id', 'produit_id')->withPivot('quantity');
    }
}
