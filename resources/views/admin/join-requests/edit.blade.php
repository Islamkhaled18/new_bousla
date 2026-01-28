@extends('layouts.admin.app')
@section('title')
    تعديل طلب الانضمام -- {{ $joinRequest->full_name }}
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
                <li class="breadcrumb-item active"><a href="#" title="تعديل طلب الانضمام">تعديل طلب الانضمام</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form action="{{ route('join-requests.update', $joinRequest) }}" method="POST"
                            enctype="multipart/form-data" id="joinRequestForm">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="first_name">الاسم الاول</label>
                                        <input class="form-control" id="first_name" name="first_name"
                                            value="{{ old('first_name', $joinRequest->first_name) }}" type="text"
                                            placeholder="اكتب الاسم الاول">
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="last_name">الاسم الثاني</label>
                                        <input class="form-control" id="last_name" name="last_name"
                                            value="{{ old('last_name', $joinRequest->last_name) }}" type="text"
                                            placeholder="اكتب الاسم الثاني">
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- gender --}}
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="gender">الجنس</label>
                                        <select class="form-control" id="gender" name="gender">
                                            <option value="male"
                                                {{ old('gender', $joinRequest->gender) == 'male' ? 'selected' : '' }}>ذكر
                                            </option>
                                            <option value="female"
                                                {{ old('gender', $joinRequest->gender) == 'female' ? 'selected' : '' }}>أنثى
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
                                            value="{{ old('phone', $joinRequest->phone) }}" type="text"
                                            placeholder="اكتب الهاتف">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="address">العنوان</label>
                                        <input class="form-control" id="address" name="address"
                                            value="{{ old('address', $joinRequest->address) }}" type="text"
                                            placeholder="اكتب العنوان">
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
                                            value="{{ old('building_number', $joinRequest->building_number) }}"
                                            type="text" placeholder="رقم العماره">
                                        @error('building_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="floor_number">رقم الطابق</label>
                                        <input class="form-control" id="floor_number" name="floor_number"
                                            value="{{ old('floor_number', $joinRequest->floor_number) }}" type="text"
                                            placeholder="رقم الطابق">
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
                                            value="{{ old('apartment_number', $joinRequest->apartment_number) }}"
                                            type="text" placeholder="رقم الشقه">
                                        @error('apartment_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="email">البريد الالكتروني</label>
                                        <input class="form-control" id="email" name="email"
                                            value="{{ old('email', $joinRequest->email) }}" type="text"
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
                                            value="{{ old('about_me', $joinRequest->about_me) }}" type="text"
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
                                            value="{{ old('id_number', $joinRequest->id_number) }}" type="text"
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
                                            value="{{ old('organization_name', $joinRequest->organization_name) }}"
                                            type="text" placeholder="اكتب اسم المنظمة">
                                        @error('organization_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="organization_phone_first">رقم هاتف المنظمة</label>
                                        <input class="form-control" id="organization_phone_first"
                                            name="organization_phone_first"
                                            value="{{ old('organization_phone_first', $joinRequest->organization_phone_first) }}"
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
                                            value="{{ old('organization_phone_second', $joinRequest->organization_phone_second) }}"
                                            type="text" placeholder="رقم هاتف ثاني للمنظمة">
                                        @error('organization_phone_second')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="organization_phone_third">رقم هاتف ثالث للمنظمة</label>
                                        <input class="form-control" id="organization_phone_third"
                                            name="organization_phone_third"
                                            value="{{ old('organization_phone_third', $joinRequest->organization_phone_third) }}"
                                            type="text" placeholder="رقم هاتف ثالث للمنظمة">
                                        @error('organization_phone_third')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="organization_location_url">رابط الموقع</label>
                                        <input class="form-control" id="organization_location_url"
                                            name="organization_location_url"
                                            value="{{ old('organization_location_url', $joinRequest->organization_location_url) }}"
                                            type="text" placeholder="رابط الموقع">
                                        @error('organization_location_url')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="job_title_id">الوظيفة</label>
                                        <select class="form-control" id="job_title_id" name="job_title_id">
                                            @foreach ($job_titles as $job_title)
                                                <option value="{{ $job_title->id }}"
                                                    {{ old('job_title_id', $joinRequest->job_title_id) == $job_title->id ? 'selected' : '' }}>
                                                    {{ $job_title->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="is_available_for_home_visits">متاح للزيارات المنزلية</label>
                                        <select class="form-control" id="is_available_for_home_visits"
                                            name="is_available_for_home_visits">
                                            <option value="1"
                                                {{ old('is_available_for_home_visits', $joinRequest->is_available_for_home_visits) == '1' ? 'selected' : '' }}>
                                                نعم
                                            </option>
                                            <option value="0"
                                                {{ old('is_available_for_home_visits', $joinRequest->is_available_for_home_visits) == '0' ? 'selected' : '' }}>
                                                لا
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="area_id">المنطقة</label>
                                        <select class="form-control" id="area_id" name="area_id">
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->id }}"
                                                    {{ old('area_id', $joinRequest->area_id) == $area->id ? 'selected' : '' }}>
                                                    {{ $area->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="is_accept_terms">موافقة على الشروط</label>
                                        <select class="form-control" id="is_accept_terms" name="is_accept_terms">
                                            <option value="1"
                                                {{ old('is_accept_terms', $joinRequest->is_accept_terms) == '1' ? 'selected' : '' }}>
                                                نعم
                                            </option>
                                            <option value="0"
                                                {{ old('is_accept_terms', $joinRequest->is_accept_terms) == '0' ? 'selected' : '' }}>
                                                لا
                                            </option>
                                        </select>
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
                                        @if ($joinRequest->personal_image)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $joinRequest->personal_image) }}"
                                                    alt="Personal Image" class="img-thumbnail" style="max-width: 150px;">
                                                <p class="text-muted small">الصورة الحالية</p>
                                            </div>
                                        @endif
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
                                        @if ($joinRequest->logo)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $joinRequest->logo) }}" alt="Logo"
                                                    class="img-thumbnail" style="max-width: 150px;">
                                                <p class="text-muted small">الشعار الحالي</p>
                                            </div>
                                        @endif
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
                                        @if ($joinRequest->id_image_front)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $joinRequest->id_image_front) }}"
                                                    alt="ID Front" class="img-thumbnail" style="max-width: 150px;">
                                                <p class="text-muted small">الصورة الحالية</p>
                                            </div>
                                        @endif
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
                                        @if ($joinRequest->id_image_back)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $joinRequest->id_image_back) }}"
                                                    alt="ID Back" class="img-thumbnail" style="max-width: 150px;">
                                                <p class="text-muted small">الصورة الحالية</p>
                                            </div>
                                        @endif
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
                                        @if ($joinRequest->graduation_certificate)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $joinRequest->graduation_certificate) }}"
                                                    alt="Graduation Certificate" class="img-thumbnail"
                                                    style="max-width: 150px;">
                                                <p class="text-muted small">الشهادة الحالية</p>
                                            </div>
                                        @endif
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
                                        @if ($joinRequest->professional_license)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $joinRequest->professional_license) }}"
                                                    alt="Professional License" class="img-thumbnail"
                                                    style="max-width: 150px;">
                                                <p class="text-muted small">الشهادة الحالية</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="syndicate_card">كارنيه النقابة</label>
                                        <input class="form-control" id="syndicate_card" name="syndicate_card"
                                            type="file" accept="image/*">
                                        @error('syndicate_card')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <span class="text-danger" id="imageError" style="display: none;"></span>
                                        <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                        @if ($joinRequest->syndicate_card)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $joinRequest->syndicate_card) }}"
                                                    alt="Syndicate Card" class="img-thumbnail" style="max-width: 150px;">
                                                <p class="text-muted small">الكارنيه الحالي</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="photo" class="form-label">صور للمنظمه</label>

                                <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                    id="photo" name="photo[]" multiple accept="image/*">
                                @error('photo[]')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror

                                @if ($joinRequest->images && $joinRequest->images->count() > 0)
                                    <div class="mt-3">
                                        <label class="form-label">الصور الحالية:</label>
                                        <div class="row">
                                            @foreach ($joinRequest->images as $image)
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <img src="{{ asset('storage/' . $image->photo) }}"
                                                            alt="Organization Photo" class="img-thumbnail"
                                                            style="max-width: 300px; max-height: 200px;">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm position-absolute"
                                                            style="top: 5px; right: 5px;"
                                                            onclick="deleteImage({{ $image->id }})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <small class="form-text text-muted">يمكنك حذف الصور الحالية أو رفع صور
                                            جديدة</small>
                                    </div>
                                @endif
                            </div>

                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit" id="submitBtn">حفظ التعديلات</button>
                                <a href="{{ route('join-requests.index') }}" class="btn btn-secondary">إلغاء</a>
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
        const deleteImageRoute = "{{ route('join-requests.images.destroy', ':id') }}";
        // دالة حذف الصورة
        function deleteImage(imageId) {
            if (confirm('هل أنت متأكد من حذف هذه الصورة؟')) {

                let url = deleteImageRoute.replace(':id', imageId);

                fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('حدث خطأ أثناء حذف الصورة');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('حدث خطأ أثناء حذف الصورة');
                    });
            }
        }


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
@endpush
