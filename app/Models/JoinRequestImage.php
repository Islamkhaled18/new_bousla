<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinRequestImage extends Model
{
    protected $table = 'join_requests_images';
    protected $guarded = ['id'];

    public function joinRequest()
    {
        return $this->belongsTo(JoinRequest::class, 'join_request_id');
    }
}
