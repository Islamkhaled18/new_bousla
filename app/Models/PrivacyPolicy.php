<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    use  HasUuid;

    protected $table = 'privacy_policies';
    protected $guarded = ['id'];
}
