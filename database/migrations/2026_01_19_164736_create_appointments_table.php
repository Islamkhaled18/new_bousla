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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            // المريض والطبيب
            $table->foreignId('patient_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();

            // تفاصيل الحجز
            $table->date('appointment_date');
            $table->time('appointment_time');

            // نوع الحجز
            // 'clinic' = حجز في العيادة
            // 'home_visit' = زيارة منزلية
            // 'urgent' = حجز عاجل
            $table->enum('appointment_type', ['clinic', 'home_visit', 'urgent'])->default('clinic');

            // حالة الحجز
            // 'pending' = قيد الانتظار
            // 'confirmed' = مؤكد
            // 'cancelled' = ملغي
            // 'completed' = مكتمل
            // 'no_show' = لم يحضر
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed', 'no_show'])->default('pending');

            // الرسوم
            $table->float('fees')->default(0);

            // ملاحظات
            $table->text('patient_notes')->nullable()->comment('Notes from patient');
            $table->text('doctor_notes')->nullable()->comment('Notes from doctor');
            $table->text('cancellation_reason')->nullable();

            // وقت الإلغاء إن وجد
            $table->timestamp('cancelled_at')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users');

            $table->timestamps();

            // فهرس لتسريع البحث
            $table->index(['doctor_id', 'appointment_date', 'status']);
            $table->index(['patient_id', 'appointment_date']);
            $table->index(['doctor_id', 'appointment_date', 'appointment_time']);
            $table->index(['patient_id', 'appointment_date', 'appointment_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
