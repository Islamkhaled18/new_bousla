<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory, HasSlug;
    protected $table   = 'cities';
    protected $fillable = [
        'name',
        'name_en',
        'slug',
        'is_active',
        'governorate_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    //relations
    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }
}
