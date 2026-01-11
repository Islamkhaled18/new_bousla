<?php
namespace App\Traits;

trait HasImageUrl
{
    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(storage_path('app/public/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        return asset('images/main_image.jpeg');
    }
}
