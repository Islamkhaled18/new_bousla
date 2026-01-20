<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\GeneratesUniqueNickname;
use App\Traits\HasUserSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasUserSlug, SoftDeletes, HasApiTokens, GeneratesUniqueNickname;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'slug',
        'first_name',
        'last_name',
        'nick_name',
        'password',
        'phone',
        'is_active',
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
        'personal_image',
        'logo',
        'id_image_front',
        'id_image_back',
        'graduation_certificate',
        'professional_license',
        'syndicate_card',
        'building_number',
        'floor_number',
        'apartment_number',
        'roles_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'roles_name' => 'array',
            'is_active' => 'boolean'
        ];
    }

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
        return $this->hasMany(UserImage::class, 'user_id');
    }
}
