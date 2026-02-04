<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'appointment_type',
        'status',
        'fees',
        'patient_notes',
        'doctor_notes',
        'cancellation_reason',
        'cancelled_at',
        'cancelled_by'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i:s',
        'fees' => 'float',
        'cancelled_at' => 'datetime'
    ];

    /**
     * العلاقة مع المريض
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * العلاقة مع الطبيب
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * العلاقة مع الشخص الذي ألغى الحجز
     */
    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    /**
     * إلغاء الحجز
     */
    public function cancel($userId, $reason = null)
    {
        $this->update([
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
            'cancelled_at' => now(),
            'cancelled_by' => $userId
        ]);
    }

    /**
     * تأكيد الحجز
     */
    public function confirm()
    {
        $this->update(['status' => 'confirmed']);
    }

    /**
     * تحديد الحجز كمكتمل
     */
    public function complete($doctorNotes = null)
    {
        $this->update([
            'status' => 'completed',
            'doctor_notes' => $doctorNotes
        ]);
    }

    /**
     * تحديد الحجز كلم يحضر
     */
    public function markAsNoShow()
    {
        $this->update(['status' => 'no_show']);
    }

    /**
     * Scope للحجوزات النشطة (pending و confirmed)
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed']);
    }

    /**
     * Scope للحجوزات المؤكدة فقط
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope للحجوزات في تاريخ معين
     */
    public function scopeOnDate($query, $date)
    {
        return $query->where('appointment_date', $date);
    }

    /**
     * Scope للحجوزات لطبيب معين
     */
    public function scopeForDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    /**
     * Scope للحجوزات لمريض معين
     */
    public function scopeForPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    /**
     * Scope للحجوزات القادمة
     */
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time');
    }

    /**
     * Scope للحجوزات السابقة
     */
    public function scopePast($query)
    {
        return $query->where('appointment_date', '<', now()->toDateString())
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc');
    }
}