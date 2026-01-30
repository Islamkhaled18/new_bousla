<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
     protected $table = 'favorites';
     protected $fillable = ['client_id', 'doctor_id'];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
