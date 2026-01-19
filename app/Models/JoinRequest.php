<?php

namespace App\Models;

use App\Traits\HasUserSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JoinRequest extends Model
{
    use HasUserSlug, SoftDeletes;

    protected $fillable = [
        'status',
        'slug',
        'first_name',
        'last_name',
        'phone',
        'address',
        'email',
        'about_me',
        'id_number',
        'job_title_id',
        'area_id',
        'organization_name',
        'organization_phone_first',
        'organization_phone_second',
        'organization_phone_third',
        'organization_location_url',
        'building_number',
        'floor_number',
        'apartment_number',
        'personal_image',
        'logo',
        'id_image_front',
        'id_image_back',
        'graduation_certificate',
        'professional_license',
        'syndicate_card',
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function images()
    {
        return $this->hasMany(JoinRequestImage::class, 'join_request_id');
    }
}
