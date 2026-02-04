@extends('layouts.admin.app')
@section('title')
    انشاء طلب انضمام جديد
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> طلبات الانضمام </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('join-requests.index') }}" title="طلبات الانضمام">طلبات
                        الانضمام</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('join-requests.create') }}"
                        title="انشاء طلب انضمام جديد">إانشاء طلب انضمام جديد</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form action="{{ route('join-requests.store') }}" method="POST" enctype="multipart/form-data"
                            id="joinRequestForm">
                            @csrf

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="first_name">الاسم الاول</label>
                                        <input class="form-control" id="first_name" name="first_name"
                                            value="{{ old('first_name') }}" type="text" placeholder="اكتب الاسم الاول">
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="last_name">الاسم الثاني</label>
                                        <input class="form-control" id="last_name" name="last_name"
                                            value="{{ old('last_name') }}" type="text" placeholder="اكتب الاسم الثاني">
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- /gender --}}
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="gender">الجنس</label>
                                        <select class="form-control" id="gender" name="gender">
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر
                                            </option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="phone">الهاتف</label>
                                        <input class="form-control" id="phone" name="phone"
                                            value="{{ old('phone') }}" type="text" placeholder="اكتب الهاتف">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="address">العنوان</label>
                                        <input class="form-control" id="address" name="address"
                                            value="{{ old('address') }}" type="text" placeholder="اكتب العنوان">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="building_number">رقم العماره</label>
                                        <input class="form-control" id="building_number" name="building_number"
                                            value="{{ old('building_number') }}" type="text" placeholder="رقم العماره">
                                        @error('building_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="floor_number">رقم الطابق</label>
                                        <input class="form-control" id="floor_number" name="floor_number"
                                            value="{{ old('floor_number') }}" type="text" placeholder="رقم الطابق">
                                        @error('floor_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="apartment_number">رقم الشقه</label>
                                        <input class="form-control" id="apartment_number" name="apartment_number"
                                            value="{{ old('apartment_number') }}" type="text"
                                            placeholder="رقم الشقه">
                                        @error('apartment_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="email">البريد الالكتروني</label>
                                        <input class="form-control" id="email" name="email"
                                            value="{{ old('email') }}" type="text"
                                            placeholder="اكتب البريد الالكتروني">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="about_me">نبذه عن الدكتور</label>
                                        <input class="form-control" id="about_me" name="about_me"
                                            value="{{ old('about_me') }}" type="text"
                                            placeholder="اكتب نبذة عن الدكتور">
                                        @error('about_me')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="id_number">رقم البطاقه</label>
                                        <input class="form-control" id="id_number" name="id_number"
                                            value="{{ old('id_number') }}" type="text"
                                            placeholder="اكتب رقم البطاقه">
                                        @error('id_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="organization_name">اسم المنظمة</label>
                                        <input class="form-control" id="organization_name" name="organization_name"
                                            value="{{ old('organization_name') }}" type="text"
                                            placeholder="اكتب اسم المنظمة">
                                        @error('organization_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="organization_phone_first">رقم هاتف المنظمة</label>
                                        <input class="form-control" id="organization_phone_first"
                                            name="organization_phone_first" value="{{ old('organization_phone_first') }}"
                                            type="text" placeholder="اكتب رقم هاتف المنظمة">
                                        @error('organization_phone_first')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="organization_phone_second">رقم هاتف ثاني للمنظمة</label>
                                        <input class="form-control" id="organization_phone_second"
                                            name="organization_phone_second"
                                            value="{{ old('organization_phone_second') }}" type="text"
                                            placeholder="رقم هاتف ثاني للمنظمة">
                                        @error('organization_phone_second')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="organization_phone_third">رقم هاتف ثالث للمنظمة</label>
                                        <input class="form-control" id="organization_phone_third"
                                            name="organization_phone_third" value="{{ old('organization_phone_third') }}"
                                            type="text" placeholder="رقم هاتف ثالث للمنظمة">
                                        @error('organization_phone_third')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="organization_location_url">رابط الموقع</label>
                                        <input class="form-control" id="organization_location_url"
                                            name="organization_location_url"
                                            value="{{ old('organization_location_url') }}" type="text"
                                            placeholder="رابط الموقع">
                                        @error('organization_location_url')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="job_title_id">الوظيفة</label>
                                        <select class="form-control" id="job_title_id" name="job_title_id">
                                            @foreach ($job_titles as $job_title)
                                                <option value="{{ $job_title->id }}">{{ $job_title->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                               <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="clinic_fees">سعر الكشف</label>
                                        <input class="form-control" id="clinic_fees" name="clinic_fees"
                                            value="{{ old('clinic_fees') }}" type="text"
                                            placeholder="سعر الكشف">
                                        @error('clinic_fees')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="urgent_fees">سعر الكشف المستعجل</label>
                                        <input class="form-control" id="urgent_fees" name="urgent_fees"
                                            value="{{ old('urgent_fees') }}" type="text"
                                            placeholder="سعر الكشف المستعجل">
                                        @error('urgent_fees')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="is_available_for_home_visits">متاح للزيارات المنزلية</label>
                                        <select class="form-control" id="is_available_for_home_visits"
                                            name="is_available_for_home_visits">
                                            <option value="1"
                                                {{ old('is_available_for_home_visits') == '1' ? 'selected' : '' }}>
                                                نعم</option>
                                            <option value="0"
                                                {{ old('is_available_for_home_visits') == '0' ? 'selected' : '' }}>
                                                لا</option>
                                        </select>
                                        @error('is_available_for_home_visits')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="home_visit_fees">سعر زيارة المنزل</label>
                                        <input class="form-control" id="home_visit_fees" name="home_visit_fees"
                                            value="{{ old('home_visit_fees') }}" type="text"
                                            placeholder="سعر الزيارة المنزلية">
                                        @error('home_visit_fees')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="area_id">المنطقة</label>
                                        <select class="form-control" id="area_id" name="area_id">
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="is_accept_terms">موافقة على الشروط والاحكام</label>

                                        <select class="form-control" id="is_accept_terms" name="is_accept_terms">
                                            <option value="1" {{ old('is_accept_terms') == '1' ? 'selected' : '' }}>
                                                نعم</option>
                                            <option value="0" {{ old('is_accept_terms') == '0' ? 'selected' : '' }}>
                                                لا</option>
                                        </select>
                                        @error('is_accept_terms')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="personal_image">صورة شخصيه</label>
                                        <input class="form-control" id="personal_image" name="personal_image"
                                            type="file" accept="image/*">
                                        @error('personal_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <span class="text-danger" id="imageError" style="display: none;"></span>
                                        <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="logo">اللوجو</label>
                                        <input class="form-control" id="logo" name="logo" type="file"
                                            accept="image/*">
                                        @error('logo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <span class="text-danger" id="imageError" style="display: none;"></span>
                                        <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="id_image_front">صورة البطاقه الاماميه</label>
                                        <input class="form-control" id="id_image_front" name="id_image_front"
                                            type="file" accept="image/*">
                                        @error('id_image_front')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <span class="text-danger" id="imageError" style="display: none;"></span>
                                        <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="id_image_back">صورة البطاقه الخلفيه</label>
                                        <input class="form-control" id="id_image_back" name="id_image_back"
                                            type="file" accept="image/*">
                                        @error('id_image_back')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <span class="text-danger" id="imageError" style="display: none;"></span>
                                        <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="graduation_certificate">شهادة التخرج</label>
                                        <input class="form-control" id="graduation_certificate"
                                            name="graduation_certificate" type="file" accept="image/*">
                                        @error('graduation_certificate')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <span class="text-danger" id="imageError" style="display: none;"></span>
                                        <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="professional_license">شهادة مزاولة المهنه</label>
                                        <input class="form-control" id="professional_license" name="professional_license"
                                            type="file" accept="image/*">
                                        @error('professional_license')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <span class="text-danger" id="imageError" style="display: none;"></span>
                                        <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="syndicate_card">كارنية النقابة</label>
                                        <input class="form-control" id="syndicate_card" name="syndicate_card"
                                            type="file" accept="image/*">
                                        @error('syndicate_card')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <span class="text-danger" id="imageError" style="display: none;"></span>
                                        <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="photo" class="form-label">صور للمنظمه</label>

                                <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                    value="{{ old('photo') }}" id="photo" name="photo[]" multiple
                                    accept="image/*">
                                @error('photo[]')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            @include('admin.join-requests.parts.doctor_schedules')

                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit" id="submitBtn">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('joinRequestForm');
            const maxSize = 5; // بالميجابايت

            // جلب كل حقول الصور
            const imageInputs = document.querySelectorAll('input[type="file"][accept="image/*"]');

            // إضافة مستمع لكل حقل صورة
            imageInputs.forEach(function(imageInput) {
                const imageError = imageInput.parentElement.querySelector('.text-danger[id="imageError"]');

                // التحقق من حجم الصورة عند اختيارها
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    imageError.style.display = 'none';
                    imageError.textContent = '';

                    if (file) {
                        const fileSize = file.size / 1024 / 1024; // تحويل إلى ميجابايت

                        if (fileSize > maxSize) {
                            imageError.textContent =
                                `حجم الصورة (${fileSize.toFixed(2)} ميجابايت) أكبر من الحد المسموح (${maxSize} ميجابايت)`;
                            imageError.style.display = 'block';
                            imageInput.value = ''; // مسح الملف
                        }
                    }
                });
            });

            // التحقق قبل إرسال الفورم
            form.addEventListener('submit', function(e) {
                let hasError = false;
                let firstError = null;

                imageInputs.forEach(function(imageInput) {
                    const file = imageInput.files[0];
                    const imageError = imageInput.parentElement.querySelector(
                        '.text-danger[id="imageError"]');

                    if (file) {
                        const fileSize = file.size / 1024 / 1024;

                        if (fileSize > maxSize) {
                            e.preventDefault();
                            hasError = true;

                            imageError.textContent =
                                `حجم الصورة (${fileSize.toFixed(2)} ميجابايت) أكبر من الحد المسموح (${maxSize} ميجابايت)`;
                            imageError.style.display = 'block';

                            // حفظ أول خطأ للتمرير إليه
                            if (!firstError) {
                                firstError = imageError;
                            }
                        }
                    }
                });

                // التمرير إلى أول رسالة خطأ
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }

                if (hasError) {
                    return false;
                }
            });
        });
    </script>
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
@endpush
