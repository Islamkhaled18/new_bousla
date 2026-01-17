<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUserSlug
{
    public static function bootHasUserSlug()
    {
        static::creating(function ($model) {
            $model->slug = static::generateUniqueSlug($model->first_name);
        });

        static::updating(function ($model) {
            if ($model->isDirty('first_name')) {
                $model->slug = static::generateUniqueSlug($model->first_name, $model->id);
            }
        });
    }

    protected static function generateUniqueSlug($first_name, $ignoreId = null)
    {
        $slug = Str::slug($first_name);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
