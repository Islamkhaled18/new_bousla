{{-- ================================ --}}
{{-- JavaScript لإدارة مواعيد العمل (Doctor Schedules) --}}
{{-- ================================ --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let scheduleIndex =
            {{ count($oldSchedules ?? (isset($joinRequest) ? $joinRequest->schedules : [])) }};

        // إضافة صف جديد
        document.getElementById('addScheduleRow').addEventListener('click', function() {
            const tbody = document.getElementById('schedulesBody');
            const newRow = createScheduleRow(scheduleIndex);
            tbody.insertAdjacentHTML('beforeend', newRow);
            scheduleIndex++;
            attachEventListeners();
        });

        // دالة إنشاء صف جديد
        function createScheduleRow(index) {
            return `
            <tr class="schedule-row">
                <td>
                    <select class="form-control form-control-sm day-select" name="schedules[${index}][day_of_week]">
                        <option value="">اختر اليوم</option>
                        <option value="saturday">السبت</option>
                        <option value="sunday">الأحد</option>
                        <option value="monday">الاثنين</option>
                        <option value="tuesday">الثلاثاء</option>
                        <option value="wednesday">الأربعاء</option>
                        <option value="thursday">الخميس</option>
                        <option value="friday">الجمعة</option>
                    </select>
                </td>
                <td>
                    <input type="time" class="form-control form-control-sm" name="schedules[${index}][from_time]">
                </td>
                <td>
                    <input type="time" class="form-control form-control-sm" name="schedules[${index}][to_time]">
                </td>
                <td>
                    <select class="form-control form-control-sm booking-type-select" name="schedules[${index}][booking_type]">
                        <option value="time_slots" selected>مواعيد محددة</option>
                        <option value="hourly_capacity">حد أقصى للمرضى</option>
                    </select>
                </td>
                <td>
                    <select class="form-control form-control-sm slot-duration" name="schedules[${index}][slot_duration]">
                        <option value="">اختر المدة</option>
                        <option value="15">15 دقيقة</option>
                        <option value="30" selected>30 دقيقة</option>
                        <option value="45">45 دقيقة</option>
                        <option value="60">60 دقيقة</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm max-patients" 
                        name="schedules[${index}][max_patients_per_hour]" 
                        min="1" max="50" value="5" disabled>
                </td>
                <td class="text-center">
                    <input type="checkbox" name="schedules[${index}][is_active]" value="1" checked>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-schedule">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        }

        // ربط Event Listeners
        function attachEventListeners() {
            // حذف صف
            document.querySelectorAll('.remove-schedule').forEach(btn => {
                btn.removeEventListener('click', removeScheduleRow);
                btn.addEventListener('click', removeScheduleRow);
            });

            // تغيير نوع الحجز
            document.querySelectorAll('.booking-type-select').forEach(select => {
                select.removeEventListener('change', handleBookingTypeChange);
                select.addEventListener('change', handleBookingTypeChange);
            });
        }

        function removeScheduleRow(e) {
            e.target.closest('tr').remove();
        }

        function handleBookingTypeChange(e) {
            const row = e.target.closest('tr');
            const bookingType = e.target.value;
            const slotDuration = row.querySelector('.slot-duration');
            const maxPatients = row.querySelector('.max-patients');

            if (bookingType === 'time_slots') {
                slotDuration.disabled = false;
                slotDuration.required = true;
                maxPatients.disabled = true;
                maxPatients.required = false;
                maxPatients.value = '';
            } else {
                slotDuration.disabled = true;
                slotDuration.required = false;
                slotDuration.value = '';
                maxPatients.disabled = false;
                maxPatients.required = true;
                if (!maxPatients.value) {
                    maxPatients.value = '5';
                }
            }
        }

        // تهيئة Event Listeners الموجودة
        attachEventListeners();
    });
</script>