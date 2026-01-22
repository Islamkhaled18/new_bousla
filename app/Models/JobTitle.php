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

        'icon_color',
        'bg_color',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

     protected $appends = ['flutter_icon'];

    /**
     * Get Flutter-compatible icon data
     */
    public function getFlutterIconAttribute(): array
    {
        return [
            'codePoint' => hexdec(str_replace('0x', '', $this->icon_unicode ?? '0xe3f0')),
            'fontFamily' => $this->icon_family ?? 'MaterialIcons',
            'color' => $this->icon_color,
            'backgroundColor' => $this->bg_color,
        ];
    }
}
