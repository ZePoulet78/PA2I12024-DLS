<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class Donation extends Model
{
    use Billable;

    protected $fillable = ['amount'];
}