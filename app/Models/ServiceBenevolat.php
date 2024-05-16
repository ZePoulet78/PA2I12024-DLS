<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBenevolat extends Model
{
    use HasFactory;

    protected $table = 'service_benevolat';

    protected $fillable = ['title', 'description', 'date', 'heure', 'id_beneficiary', 'id_volunteer'];

    public function beneficiary()
    {
        return $this->belongsTo(User::class, 'id_beneficiary');
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'id_volunteer');
    }


}
