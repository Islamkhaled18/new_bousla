<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory, HasSlug;
    protected $table   = 'cities';
    protected $guarded = ['id'];

    //relations
    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }
}
