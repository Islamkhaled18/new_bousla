<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class userImage extends Model
{
    protected $table = 'user_images';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
