<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobTitle extends Model
{
    use HasFactory, HasSlug;
    protected $table   = 'job_titles';
    protected $fillable = [
        'name',
        'name_en',
        'slug',
        'is_active',
        'icon',
        'icon_color',
        'bg_color',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
