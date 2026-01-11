<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function booted()
    {

        static::created(function ($model) {

            $model->uuid = Str::uuid();
            $model->save();
        });

        static::updating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });
    }
}
