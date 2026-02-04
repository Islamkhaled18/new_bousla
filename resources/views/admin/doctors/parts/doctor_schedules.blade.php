{{-- ================================ --}}
{{-- قسم مواعيد العمل (Doctor Schedules) --}}
{{-- ================================ --}}
<div class="row mt-4">
    <div class="col-12">
        <h4 class="mb-3">مواعيد العمل</h4>
        <div class="table-responsive">
            <table class="table table-bordered" id="schedulesTable">
                <thead class="bg-light">
                    <tr>
                        <th width="15%">اليوم</th>
                        <th width="13%">من الساعة</th>
                        <th width="13%">إلى الساعة</th>
                        <th width="17%">نوع الحجز</th>
                        <th width="15%">مدة الموعد (بالدقائق)</th>
                        <th width="15%">الحد الأقصى/ساعة</th>
                        <th width="7%">مفعل</th>
                        @if (!isset($isShowPage) || !$isShowPage)
                            <th width="5%">حذف</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="schedulesBody">
                    @php
                        $existingSchedules = isset($doctor) ? $doctor->schedules : collect();
                        $oldSchedules = old('schedules', []);
                    @endphp

                    @if (count($oldSchedules) > 0)
                        {{-- عرض البيانات القديمة في حالة validation error --}}
                        @foreach ($oldSchedules as $index => $schedule)
                            <tr class="schedule-row">
                                <td>
                                    <select class="form-control form-control-sm day-select"
                                        name="schedules[{{ $index }}][day_of_week]">
                                        <option value="">اختر اليوم</option>
                                        <option value="saturday"
                                            {{ $schedule['day_of_week'] == 'saturday' ? 'selected' : '' }}>
                                            السبت</option>
                                        <option value="sunday"
                                            {{ $schedule['day_of_week'] == 'sunday' ? 'selected' : '' }}>
                                            الأحد</option>
                                        <option value="monday"
                                            {{ $schedule['day_of_week'] == 'monday' ? 'selected' : '' }}>
                                            الاثنين</option>
                                        <option value="tuesday"
                                            {{ $schedule['day_of_week'] == 'tuesday' ? 'selected' : '' }}>
                                            الثلاثاء</option>
                                        <option value="wednesday"
                                            {{ $schedule['day_of_week'] == 'wednesday' ? 'selected' : '' }}>
                                            الأربعاء</option>
                                        <option value="thursday"
                                            {{ $schedule['day_of_week'] == 'thursday' ? 'selected' : '' }}>
                                            الخميس</option>
                                        <option value="friday"
                                            {{ $schedule['day_of_week'] == 'friday' ? 'selected' : '' }}>
                                            الجمعة</option>
                                    </select>
                                    @error("schedules.{$index}.day_of_week")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>
                                    <input type="time" class="form-control form-control-sm"
                                        name="schedules[{{ $index }}][from_time]"
                                        value="{{ $schedule['from_time'] ?? '' }}">
                                    @error("schedules.{$index}.from_time")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>
                                    <input type="time" class="form-control form-control-sm"
                                        name="schedules[{{ $index }}][to_time]"
                                        value="{{ $schedule['to_time'] ?? '' }}">
                                    @error("schedules.{$index}.to_time")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>
                                    <select class="form-control form-control-sm booking-type-select"
                                        name="schedules[{{ $index }}][booking_type]">
                                        <option value="time_slots"
                                            {{ ($schedule['booking_type'] ?? '') == 'time_slots' ? 'selected' : '' }}>
                                            مواعيد محددة</option>
                                        <option value="hourly_capacity"
                                            {{ ($schedule['booking_type'] ?? '') == 'hourly_capacity' ? 'selected' : '' }}>
                                            حد أقصى للمرضى</option>
                                    </select>
                                    @error("schedules.{$index}.booking_type")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>
                                    <select class="form-control form-control-sm slot-duration"
                                        name="schedules[{{ $index }}][slot_duration]"
                                        {{ ($schedule['booking_type'] ?? 'time_slots') != 'time_slots' ? 'disabled' : '' }}>
                                        <option value="">اختر المدة</option>
                                        <option value="15"
                                            {{ ($schedule['slot_duration'] ?? '') == 15 ? 'selected' : '' }}>
                                            15 دقيقة</option>
                                        <option value="30"
                                            {{ ($schedule['slot_duration'] ?? '') == 30 ? 'selected' : '' }}>
                                            30 دقيقة</option>
                                        <option value="45"
                                            {{ ($schedule['slot_duration'] ?? '') == 45 ? 'selected' : '' }}>
                                            45 دقيقة</option>
                                        <option value="60"
                                            {{ ($schedule['slot_duration'] ?? '') == 60 ? 'selected' : '' }}>
                                            60 دقيقة</option>
                                    </select>
                                    @error("schedules.{$index}.slot_duration")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm max-patients"
                                        name="schedules[{{ $index }}][max_patients_per_hour]"
                                        value="{{ $schedule['max_patients_per_hour'] ?? '' }}" min="1"
                                        max="50"
                                        {{ ($schedule['booking_type'] ?? 'time_slots') != 'hourly_capacity' ? 'disabled' : '' }}>
                                    @error("schedules.{$index}.max_patients_per_hour")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="schedules[{{ $index }}][is_active]"
                                        value="1" {{ $schedule['is_active'] ?? 1 ? 'checked' : '' }}>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-schedule">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @elseif(isset($doctor) && $existingSchedules->count() > 0)
                        {{-- عرض البيانات الموجودة عند التعديل --}}
                        @foreach ($existingSchedules as $index => $schedule)
                            <tr class="schedule-row">
                                <td>
                                    <select class="form-control form-control-sm day-select"
                                        name="schedules[{{ $index }}][day_of_week]">
                                        <option value="">اختر اليوم</option>
                                        <option value="saturday"
                                            {{ $schedule->day_of_week == 'saturday' ? 'selected' : '' }}>
                                            السبت</option>
                                        <option value="sunday"
                                            {{ $schedule->day_of_week == 'sunday' ? 'selected' : '' }}>
                                            الأحد</option>
                                        <option value="monday"
                                            {{ $schedule->day_of_week == 'monday' ? 'selected' : '' }}>
                                            الاثنين</option>
                                        <option value="tuesday"
                                            {{ $schedule->day_of_week == 'tuesday' ? 'selected' : '' }}>
                                            الثلاثاء</option>
                                        <option value="wednesday"
                                            {{ $schedule->day_of_week == 'wednesday' ? 'selected' : '' }}>
                                            الأربعاء</option>
                                        <option value="thursday"
                                            {{ $schedule->day_of_week == 'thursday' ? 'selected' : '' }}>
                                            الخميس</option>
                                        <option value="friday"
                                            {{ $schedule->day_of_week == 'friday' ? 'selected' : '' }}>
                                            الجمعة</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="time" class="form-control form-control-sm"
                                        name="schedules[{{ $index }}][from_time]"
                                        value="{{ \Carbon\Carbon::parse($schedule->from_time)->format('H:i') }}">
                                </td>
                                <td>
                                    <input type="time" class="form-control form-control-sm"
                                        name="schedules[{{ $index }}][to_time]"
                                        value="{{ \Carbon\Carbon::parse($schedule->to_time)->format('H:i') }}">
                                </td>
                                <td>
                                    <select class="form-control form-control-sm booking-type-select"
                                        name="schedules[{{ $index }}][booking_type]">
                                        <option value="time_slots"
                                            {{ $schedule->booking_type == 'time_slots' ? 'selected' : '' }}>
                                            مواعيد محددة</option>
                                        <option value="hourly_capacity"
                                            {{ $schedule->booking_type == 'hourly_capacity' ? 'selected' : '' }}>
                                            حد أقصى للمرضى</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control form-control-sm slot-duration"
                                        name="schedules[{{ $index }}][slot_duration]"
                                        {{ $schedule->booking_type != 'time_slots' ? 'disabled' : '' }}>
                                        <option value="">اختر المدة</option>
                                        <option value="15" {{ $schedule->slot_duration == 15 ? 'selected' : '' }}>
                                            15 دقيقة</option>
                                        <option value="30" {{ $schedule->slot_duration == 30 ? 'selected' : '' }}>
                                            30 دقيقة</option>
                                        <option value="45" {{ $schedule->slot_duration == 45 ? 'selected' : '' }}>
                                            45 دقيقة</option>
                                        <option value="60" {{ $schedule->slot_duration == 60 ? 'selected' : '' }}>
                                            60 دقيقة</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm max-patients"
                                        name="schedules[{{ $index }}][max_patients_per_hour]"
                                        value="{{ $schedule->max_patients_per_hour }}" min="1" max="50"
                                        {{ $schedule->booking_type != 'hourly_capacity' ? 'disabled' : '' }}>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="schedules[{{ $index }}][is_active]"
                                        value="1" {{ $schedule->is_active ? 'checked' : '' }}>
                                </td>
                                @if (!isset($isShowPage) || !$isShowPage)
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-schedule">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        @if (!isset($isShowPage) || !$isShowPage)
            <button type="button" class="btn btn-success btn-sm" id="addScheduleRow">
                <i class="fa fa-plus"></i> إضافة يوم عمل
            </button>
        @endif
    </div>
</div>
{{-- ================================ --}}
{{-- قسم مواعيد العمل نهاية (End Doctor Schedules) --}}
{{-- ================================ --}}
