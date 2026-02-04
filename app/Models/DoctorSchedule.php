<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'day_of_week',
        'from_time',
        'to_time',
        'booking_type',
        'slot_duration',
        'max_patients_per_hour',
        'is_active'
    ];

    protected $casts = [
        'from_time' => 'datetime:H:i:s',
        'to_time' => 'datetime:H:i:s',
        'is_active' => 'boolean'
    ];

    /**
     * relation with doctor (users table)
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * الحصول على المواعيد المتاحة بناءً على نوع الحجز
     */
    public function getAvailableSlots($date)
    {
        if ($this->booking_type === 'time_slots') {
            return $this->getTimeSlots($date);
        } else {
            return $this->getHourlyCapacitySlots($date);
        }
    }

    /**
     * الحصول على المواعيد المحددة (time_slots)
     */
    private function getTimeSlots($date)
    {
        $slots = [];
        $current = Carbon::parse($this->from_time);
        $end = Carbon::parse($this->to_time);

        while ($current->lt($end)) {
            $timeSlot = $current->format('H:i:s');
            
            // التحقق من عدم وجود حجز
            $hasAppointment = Appointment::where('doctor_id', $this->user_id)
                ->where('appointment_date', $date)
                ->where('appointment_time', $timeSlot)
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();

            if (!$hasAppointment) {
                $slots[] = $current->format('H:i');
            }

            $current->addMinutes($this->slot_duration);
        }

        return $slots;
    }

    /**
     * الحصول على الساعات المتاحة مع عدد الأماكن (hourly_capacity)
     */
    private function getHourlyCapacitySlots($date)
    {
        $slots = [];
        $current = Carbon::parse($this->from_time);
        $end = Carbon::parse($this->to_time);

        while ($current->lt($end)) {
            $hourStart = $current->format('H:i:s');
            $hourEnd = $current->copy()->addHour()->format('H:i:s');

            // عدد الحجوزات في هذه الساعة
            $bookedCount = Appointment::where('doctor_id', $this->user_id)
                ->where('appointment_date', $date)
                ->where('appointment_time', '>=', $hourStart)
                ->where('appointment_time', '<', $hourEnd)
                ->whereIn('status', ['pending', 'confirmed'])
                ->count();

            $availableSpots = $this->max_patients_per_hour - $bookedCount;

            if ($availableSpots > 0) {
                $slots[] = [
                    'hour' => $current->format('H:i'),
                    'available_spots' => $availableSpots,
                    'total_capacity' => $this->max_patients_per_hour
                ];
            }

            $current->addHour();
        }

        return $slots;
    }

    /**
     * التحقق من إمكانية الحجز في وقت معين
     */
    public function canBook($date, $time)
    {
        if (!$this->is_active) {
            return false;
        }

        $requestedTime = Carbon::parse($time);
        $fromTime = Carbon::parse($this->from_time);
        $toTime = Carbon::parse($this->to_time);

        // التحقق من أن الوقت ضمن ساعات العمل
        if ($requestedTime->lt($fromTime) || $requestedTime->gte($toTime)) {
            return false;
        }

        if ($this->booking_type === 'time_slots') {
            return $this->canBookTimeSlot($date, $time);
        } else {
            return $this->canBookHourlyCapacity($date, $time);
        }
    }

    /**
     * التحقق من إمكانية الحجز - نظام time_slots
     */
    private function canBookTimeSlot($date, $time)
    {
        // التحقق من عدم وجود حجز في هذا الموعد
        return !Appointment::where('doctor_id', $this->user_id)
            ->where('appointment_date', $date)
            ->where('appointment_time', $time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();
    }

    /**
     * التحقق من إمكانية الحجز - نظام hourly_capacity
     */
    private function canBookHourlyCapacity($date, $time)
    {
        $requestedTime = Carbon::parse($time);
        $hourStart = $requestedTime->format('H:00:00');
        $hourEnd = $requestedTime->copy()->addHour()->format('H:00:00');

        // عدد الحجوزات في هذه الساعة
        $bookedCount = Appointment::where('doctor_id', $this->user_id)
            ->where('appointment_date', $date)
            ->where('appointment_time', '>=', $hourStart)
            ->where('appointment_time', '<', $hourEnd)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        return $bookedCount < $this->max_patients_per_hour;
    }

    /**
     * Scope للحصول على الجدول النشط فقط
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Scope للحصول على جدول يوم معين
     */
    public function scopeForDay($query, $dayOfWeek)
    {
        return $query->where('day_of_week', strtolower($dayOfWeek));
    }
}