<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MakeActivity extends Model
{
    use HasFactory;

        protected $table = 'make_activity';

        protected $fillable = [
            'user_id', 'activity_id'
        ];
    
        // Définir les relations
        public function user()
        {
            return $this->belongsTo(User::class);
        }
    
        public function activite()
        {
            return $this->belongsTo(Activite::class);
        }
}
