@extends('layouts.admin.app')
@section('title')
    عرض بيانات الطبيب -- {{ $doctor->full_name }}
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> بيانات الطبيب </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('doctors.index') }}" title="بيانات الطبيب">الاطباء</a></li>
                بيانات الطبيب </a></li>
                <li class="breadcrumb-item active"><a href="#" title="عرض بيانات الطبيب">عرض بيانات الطبيب</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="first_name">الاسم الاول</label>
                                    <input class="form-control" id="first_name" name="first_name" readonly
                                        value="{{ old('first_name', $doctor->first_name) }}" type="text"
                                        placeholder="اكتب الاسم الاول">

                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="last_name">الاسم الثاني</label>
                                    <input class="form-control" id="last_name" name="last_name" readonly
                                        value="{{ old('last_name', $doctor->last_name) }}" type="text"
                                        placeholder="اكتب الاسم الثاني">

                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="gender">الجنس</label>
                                    <select class="form-control" id="gender" name="gender" readonly>
                                        <option value="male"
                                            {{ old('gender', $doctor->gender) == 'male' ? 'selected' : '' }}>ذكر
                                        </option>
                                        <option value="female"
                                            {{ old('gender', $doctor->gender) == 'female' ? 'selected' : '' }}>أنثى
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone">الهاتف</label>
                                    <input class="form-control" id="phone" name="phone" readonly
                                        value="{{ old('phone', $doctor->phone) }}" type="text" placeholder="اكتب الهاتف">

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="address">العنوان</label>
                                    <input class="form-control" id="address" name="address" readonly
                                        value="{{ old('address', $doctor->address) }}" type="text"
                                        placeholder="اكتب العنوان">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="building_number">رقم العماره</label>
                                    <input class="form-control" id="building_number" name="building_number" readonly
                                        value="{{ old('building_number', $doctor->building_number) }}" type="text"
                                        placeholder="رقم العماره">

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="floor_number">رقم الطابق</label>
                                    <input class="form-control" id="floor_number" name="floor_number" readonly
                                        value="{{ old('floor_number', $doctor->floor_number) }}" type="text"
                                        placeholder="رقم الطابق">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="apartment_number">رقم الشقه</label>
                                    <input class="form-control" id="apartment_number" name="apartment_number" readonly
                                        value="{{ old('apartment_number', $doctor->apartment_number) }}" type="text"
                                        placeholder="رقم الشقه">

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">البريد الالكتروني</label>
                                    <input class="form-control" id="email" name="email" readonly
                                        value="{{ old('email', $doctor->email) }}" type="text"
                                        placeholder="اكتب البريد الالكتروني">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="about_me">نبذه عن الدكتور</label>
                                    <input class="form-control" id="about_me" name="about_me" readonly
                                        value="{{ old('about_me', $doctor->about_me) }}" type="text"
                                        placeholder="اكتب نبذة عن الدكتور">

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="id_number">رقم البطاقه</label>
                                    <input class="form-control" id="id_number" name="id_number" readonly
                                        value="{{ old('id_number', $doctor->id_number) }}" type="text"
                                        placeholder="اكتب رقم البطاقه">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="organization_name">اسم المنظمة</label>
                                    <input class="form-control" id="organization_name" name="organization_name" readonly
                                        value="{{ old('organization_name', $doctor->organization_name) }}" type="text"
                                        placeholder="اكتب اسم المنظمة">

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="organization_phone_first">رقم هاتف المنظمة</label>
                                    <input class="form-control" id="organization_phone_first"
                                        name="organization_phone_first" readonly
                                        value="{{ old('organization_phone_first', $doctor->organization_phone_first) }}"
                                        type="text" placeholder="اكتب رقم هاتف المنظمة">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="organization_phone_second">رقم هاتف ثاني للمنظمة</label>
                                    <input class="form-control" id="organization_phone_second" readonly
                                        name="organization_phone_second"
                                        value="{{ old('organization_phone_second', $doctor->organization_phone_second) }}"
                                        type="text" placeholder="رقم هاتف ثاني للمنظمة">

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="organization_phone_third">رقم هاتف ثالث للمنظمة</label>
                                    <input class="form-control" id="organization_phone_third" readonly
                                        name="organization_phone_third"
                                        value="{{ old('organization_phone_third', $doctor->organization_phone_third) }}"
                                        type="text" placeholder="رقم هاتف ثالث للمنظمة">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="organization_location_url">رابط الموقع</label>
                                    <div>
                                        <a href="{{ $doctor->organization_location_url }}" target="_blank"
                                            class="btn btn-outline-primary">
                                            <i class="fas fa-map-marker-alt"></i> عرض الموقع على الخريطة
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="job_title_id">الوظيفة</label>
                                    <select class="form-control" id="job_title_id" name="job_title_id" readonly>
                                        @foreach ($job_titles as $job_title)
                                            <option value="{{ $job_title->id }}"
                                                {{ old('job_title_id', $doctor->job_title_id) == $job_title->id ? 'selected' : '' }}>
                                                {{ $job_title->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="is_available_for_home_visits">متاح للزيارات المنزلية</label>
                                    <select class="form-control" id="is_available_for_home_visits" readonly
                                        name="is_available_for_home_visits">
                                        <option value="1"
                                            {{ old('is_available_for_home_visits', $doctor->is_available_for_home_visits) == '1' ? 'selected' : '' }}>
                                            نعم
                                        </option>
                                        <option value="0"
                                            {{ old('is_available_for_home_visits', $doctor->is_available_for_home_visits) == '0' ? 'selected' : '' }}>
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
                                    <select class="form-control" id="area_id" name="area_id" readonly>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}"
                                                {{ old('area_id', $doctor->area_id) == $area->id ? 'selected' : '' }}>
                                                {{ $area->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="is_accept_terms">موافقة على الشروط</label>
                                    <select class="form-control" id="is_accept_terms" name="is_accept_terms" readonly>
                                        <option value="1"
                                            {{ old('is_accept_terms', $doctor->is_accept_terms) == '1' ? 'selected' : '' }}>
                                            نعم
                                        </option>
                                        <option value="0"
                                            {{ old('is_accept_terms', $doctor->is_accept_terms) == '0' ? 'selected' : '' }}>
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
                                    <span class="text-danger" id="imageError" style="display: none;"></span>
                                    <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                    @if ($doctor->personal_image)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $doctor->personal_image) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $doctor->personal_image) }}"
                                                    alt="Personal Image" class="img-thumbnail"
                                                    style="max-width: 150px; cursor: pointer;">
                                            </a>
                                            <p class="text-muted small">الصورة الحالية (اضغط للعرض بحجم كامل)</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="logo">اللوجو</label>
                                    <span class="text-danger" id="imageError" style="display: none;"></span>
                                    <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                    @if ($doctor->logo)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $doctor->logo) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $doctor->logo) }}" alt="Logo"
                                                    class="img-thumbnail" style="max-width: 150px; cursor: pointer;">
                                            </a>
                                            <p class="text-muted small">الشعار الحالي (اضغط للعرض بحجم كامل)</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="id_image_front">صورة البطاقه الاماميه</label>
                                    <span class="text-danger" id="imageError" style="display: none;"></span>
                                    <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                    @if ($doctor->id_image_front)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $doctor->id_image_front) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $doctor->id_image_front) }}"
                                                    alt="ID Front" class="img-thumbnail"
                                                    style="max-width: 150px; cursor: pointer;">
                                            </a>
                                            <p class="text-muted small">الصورة الحالية (اضغط للعرض بحجم كامل)</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="id_image_back">صورة البطاقه الخلفيه</label>
                                    <span class="text-danger" id="imageError" style="display: none;"></span>
                                    <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                    @if ($doctor->id_image_back)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $doctor->id_image_back) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $doctor->id_image_back) }}"
                                                    alt="ID Back" class="img-thumbnail"
                                                    style="max-width: 150px; cursor: pointer;">
                                            </a>
                                            <p class="text-muted small">الصورة الحالية (اضغط للعرض بحجم كامل)</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="graduation_certificate">شهادة التخرج</label>
                                    <span class="text-danger" id="imageError" style="display: none;"></span>
                                    <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                    @if ($doctor->graduation_certificate)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $doctor->graduation_certificate) }}"
                                                target="_blank">
                                                <img src="{{ asset('storage/' . $doctor->graduation_certificate) }}"
                                                    alt="Graduation Certificate" class="img-thumbnail"
                                                    style="max-width: 150px; cursor: pointer;">
                                            </a>
                                            <p class="text-muted small">الشهادة الحالية (اضغط للعرض بحجم كامل)</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="professional_license">شهادة مزاولة المهنه</label>
                                    <span class="text-danger" id="imageError" style="display: none;"></span>
                                    <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                    @if ($doctor->professional_license)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $doctor->professional_license) }}"
                                                target="_blank">
                                                <img src="{{ asset('storage/' . $doctor->professional_license) }}"
                                                    alt="Professional License" class="img-thumbnail"
                                                    style="max-width: 150px; cursor: pointer;">
                                            </a>
                                            <p class="text-muted small">الشهادة الحالية (اضغط للعرض بحجم كامل)</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="syndicate_card">كارنيه النقابة</label>
                                    <span class="text-danger" id="imageError" style="display: none;"></span>
                                    <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                    @if ($doctor->syndicate_card)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $doctor->syndicate_card) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $doctor->syndicate_card) }}"
                                                    alt="Syndicate Card" class="img-thumbnail"
                                                    style="max-width: 150px; cursor: pointer;">
                                            </a>
                                            <p class="text-muted small">الكارنيه الحالي (اضغط للعرض بحجم كامل)</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="photo" class="form-label">صور للمنظمه</label>
                            @if ($doctor->images && $doctor->images->count() > 0)
                                <div class="mt-3">
                                    <div class="row">
                                        @foreach ($doctor->images as $image)
                                            <div class="col-md-3 mb-3">
                                                <div class="position-relative">
                                                    <a href="{{ asset('storage/' . $image->photo) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $image->photo) }}"
                                                            alt="Organization Photo" class="img-thumbnail"
                                                            style="max-width: 300px; max-height: 200px; cursor: pointer;">
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small class="form-text text-muted">اضغط على أي صورة لعرضها بحجم كامل في تاب
                                        جديد</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
