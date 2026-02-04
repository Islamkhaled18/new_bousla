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
    protected $guarded = ['id'];

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

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'client_id', 'doctor_id')
            ->withTimestamps();
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'doctor_id', 'client_id')
            ->withTimestamps();
    }

    /**
     * العلاقة مع مواعيد عمل الطبيب
     */
    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class, 'user_id');
    }

    /**
     * الحصول على المواعيد النشطة فقط
     */
    public function activeSchedules()
    {
        return $this->hasMany(DoctorSchedule::class, 'user_id')->where('is_active', 1);
    }

    /**
     * العلاقة مع الحجوزات كطبيب
     */
    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    /**
     * العلاقة مع الحجوزات كمريض
     */
    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }


    //scopes

    public function scopeActiveDoctors($query)
    {
        return $query->where('is_active', 1)
            ->where('type', 'doctor')->where('is_accept_terms', 1)->where('status', 'accepted');
    }

    /**
     * Scope للأطباء الذين لديهم مواعيد عمل
     */
    public function scopeWithSchedules($query)
    {
        return $query->whereHas('schedules');
    }

    /**
     * Scope للأطباء الذين لديهم مواعيد عمل نشطة
     */
    public function scopeWithActiveSchedules($query)
    {
        return $query->whereHas('schedules', function ($q) {
            $q->where('is_active', 1);
        });
    }
}
