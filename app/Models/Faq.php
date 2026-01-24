<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasUuid;
    protected $table   = 'faqs';

    protected $fillable = [
        'question',
        'answer',
        'is_active',
    ];
}
