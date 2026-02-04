<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
         $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            // أيام الأسبوع (0 = الأحد، 1 = الاثنين، ... 6 = السبت)
            $table->enum('day_of_week', ['saturday','sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday']);
            
            // مواعيد العمل
            $table->time('from_time');
            $table->time('to_time');
            
            // نوع نظام الحجز
            // 'time_slots' = حجز بمواعيد محددة (2:00, 2:15, 2:30)
            // 'hourly_capacity' = حجز بحد أقصى للمرضى في الساعة
            $table->enum('booking_type', ['time_slots', 'hourly_capacity'])->default('time_slots');
            
            // للحجز بالمواعيد المحددة (time_slots)
            // مدة الحجز بالدقائق (مثلاً: 15، 30، 45، 60)
            $table->integer('slot_duration')->nullable()->comment('Duration in minutes for each appointment slot');
            
            // للحجز بالحد الأقصى في الساعة (hourly_capacity)
            // عدد المرضى المسموح بهم في الساعة الواحدة
            $table->integer('max_patients_per_hour')->nullable()->comment('Maximum number of patients allowed per hour');
            
            // حالة اليوم (فعال أو معطل)
            $table->boolean('is_active')->default(1);
            
            $table->timestamps();
            
            // منع تكرار نفس اليوم لنفس الطبيب
            $table->unique(['user_id', 'day_of_week']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
