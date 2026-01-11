<?php

namespace App\Models;

use App\Traits\HasImageUrl;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory, HasSlug, HasImageUrl;

    protected $table   = "ads";
    protected $guarded = ['id'];

    protected $casts = [
        'is_active'  => 'boolean',
        'start_date' => 'date',
        'end_date'   => 'date',
    ];
}
