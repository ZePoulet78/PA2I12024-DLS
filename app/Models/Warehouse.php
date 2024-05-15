<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = ['name', 'address', 'actual_capacity', 'max_capacity'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
