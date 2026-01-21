<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsAcceptance extends Model
{
    protected $table = 'terms_acceptances';
    protected $guarded = ['id'];

    protected $casts = [
        'accepted_at' => 'datetime',
    ];

    public function termCondition()
    {
        return $this->belongsTo(TermCondition::class, 'terms_condition_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
