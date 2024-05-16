<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produit;
use App\Models\User;
use App\Models\Vehicle;


class Maraude extends Model
{
    use HasFactory;

    protected $table = 'maraude'; 
    
    protected $fillable = [
        'maraud_date',
        'departure_time',
        'return_time',
        'itinerary',
        'vehicle_id',
        'user_id'
    ];

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'maraude_produit', 'maraude_id', 'produit_id')->withPivot('quantity');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
