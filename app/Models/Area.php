<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory, HasSlug;
    protected $table   = 'areas';
    protected $guarded = ['id'];

    //relations
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
