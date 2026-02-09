{{-- ================================ --}}
{{-- Form Fields للطبيب --}}
{{-- يستخدم في صفحات الإنشاء والتعديل --}}
{{-- ================================ --}}

@php

    $data = $joinRequest ?? null;
@endphp

{{-- الاسم والجنس --}}
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="first_name">الاسم الاول<span class="text-danger">*</span></label>
            <input class="form-control" id="first_name" name="first_name"
                value="{{ old('first_name', $data->first_name ?? '') }}" type="text" placeholder="اكتب الاسم الاول">
            @error('first_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="last_name">الاسم الثاني<span class="text-danger">*</span></label>
            <input class="form-control" id="last_name" name="last_name"
                value="{{ old('last_name', $data->last_name ?? '') }}" type="text" placeholder="اكتب الاسم الثاني">
            @error('last_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="public_name">اسم الشهره (ان وجد)</label>
            <input class="form-control" id="public_name" name="public_name"
                value="{{ old('public_name', $data->public_name ?? '') }}" type="text"
                placeholder="اكتب اسم الشهره (ان وجد)">
            @error('public_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

{{-- الجنس والهاتف والبريد --}}
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="gender">الجنس<span class="text-danger">*</span></label>
            <select class="form-control" id="gender" name="gender">
                <option value="male" {{ old('gender', $data->gender ?? '') == 'male' ? 'selected' : '' }}>ذكر</option>
                <option value="female" {{ old('gender', $data->gender ?? '') == 'female' ? 'selected' : '' }}>أنثى
                </option>
            </select>
            @error('gender')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="phone">الهاتف الشخصي<span class="text-danger">*</span><span class="text-danger" style="font-size: 8px;">
    (خاصة بالإدارة ولن يتم عرضها للمرضى)
</span></label>
            
            <input class="form-control" id="phone" name="phone" value="{{ old('phone', $data->phone ?? '') }}"
                type="text" placeholder=" اكتب الهاتف الشخصي">
            @error('phone')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="email">البريد الالكتروني<span class="text-danger">*</span><span class="text-danger" style="font-size: 8px;">
    (خاصة بالإدارة ولن يتم عرضها للمرضى)
</span></label>
            <input class="form-control" id="email" name="email" value="{{ old('email', $data->email ?? '') }}"
                type="text" placeholder="اكتب البريد الالكتروني">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

{{-- العنوان والمنطقة --}}
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="address">العنوان<span class="text-danger">*</span></label>
            <input class="form-control" id="address" name="address"
                value="{{ old('address', $data->address ?? '') }}" type="text" placeholder="اكتب العنوان">
            @error('address')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="address_label">علامه مميزه</label>
            <input class="form-control" id="address_label" name="address_label"
                value="{{ old('address_label', $data->address_label ?? '') }}" type="text"
                placeholder="اكتب علامه مميزه">
            @error('address_label')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="area_id">المنطقة<span class="text-danger">*</span></label>
            <select class="form-control" id="area_id" name="area_id">
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}"
                        {{ old('area_id', $data->area_id ?? '') == $area->id ? 'selected' : '' }}>
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

{{-- تفاصيل العنوان --}}
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="building_number">رقم العماره<span class="text-danger">*</span></label>
            <input class="form-control" id="building_number" name="building_number"
                value="{{ old('building_number', $data->building_number ?? '') }}" type="text"
                placeholder="رقم العماره">
            @error('building_number')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="floor_number">رقم الطابق<span class="text-danger">*</span></label>
            <input class="form-control" id="floor_number" name="floor_number"
                value="{{ old('floor_number', $data->floor_number ?? '') }}" type="text"
                placeholder="رقم الطابق">
            @error('floor_number')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="apartment_number">رقم الشقه<span class="text-danger">*</span></label>
            <input class="form-control" id="apartment_number" name="apartment_number"
                value="{{ old('apartment_number', $data->apartment_number ?? '') }}" type="text"
                placeholder="رقم الشقه">
            @error('apartment_number')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

{{-- نبذة ورقم البطاقة وتاريخ الميلاد --}}
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="about_me">نبذه عن الدكتور<span class="text-danger">*</span></label>
            <input class="form-control" id="about_me" name="about_me"
                value="{{ old('about_me', $data->about_me ?? '') }}" type="text"
                placeholder="اكتب نبذة عن الدكتور">
            @error('about_me')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="id_number">رقم البطاقه<span class="text-danger">*</span></label>
            <input class="form-control" id="id_number" name="id_number"
                value="{{ old('id_number', $data->id_number ?? '') }}" type="text"
                placeholder="اكتب رقم البطاقه">
            @error('id_number')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="date_of_birth">تاريخ الميلاد<span class="text-danger" style="font-size: 8px;">
    (خاصة بالإدارة ولن يتم عرضها للمرضى)
</span></label>
            <input class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth"
                name="date_of_birth"
                value="{{ old('date_of_birth', isset($data->date_of_birth) ? \Carbon\Carbon::parse($data->date_of_birth)->format('Y-m-d') : '') }}"
                type="date">

            @error('date_of_birth')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

{{-- بيانات المنظمة --}}
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="organization_name">اسم المنظمة<span class="text-danger">*</span></label>
            <input class="form-control" id="organization_name" name="organization_name"
                value="{{ old('organization_name', $data->organization_name ?? '') }}" type="text"
                placeholder="اكتب اسم المنظمة">
            @error('organization_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="organization_phone_first">رقم هاتف المنظمة</label>
            <input class="form-control" id="organization_phone_first" name="organization_phone_first"
                value="{{ old('organization_phone_first', $data->organization_phone_first ?? '') }}" type="text"
                placeholder="اكتب رقم هاتف المنظمة">
            @error('organization_phone_first')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="organization_phone_second">رقم هاتف ثاني للمنظمة</label>
            <input class="form-control" id="organization_phone_second" name="organization_phone_second"
                value="{{ old('organization_phone_second', $data->organization_phone_second ?? '') }}" type="text"
                placeholder="رقم هاتف ثاني للمنظمة">
            @error('organization_phone_second')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="organization_phone_third">رقم هاتف ثالث للمنظمة</label>
            <input class="form-control" id="organization_phone_third" name="organization_phone_third"
                value="{{ old('organization_phone_third', $data->organization_phone_third ?? '') }}" type="text"
                placeholder="رقم هاتف ثالث للمنظمة">
            @error('organization_phone_third')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

{{-- موقع المنظمة والوظيفة --}}
<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label for="organization_location_url">رابط العنوان على جوجل مابس<span class="text-danger">*</span></label>
            <input class="form-control" id="organization_location_url" name="organization_location_url"
                value="{{ old('organization_location_url', $data->organization_location_url ?? '') }}" type="text"
                placeholder="رابط العنوان على جوجل مابس">
            @error('organization_location_url')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group">
            <label for="job_title_id">الوظيفة<span class="text-danger">*</span></label>
            <select class="form-control" id="job_title_id" name="job_title_id">
                @foreach ($job_titles as $job_title)
                    <option value="{{ $job_title->id }}"
                        {{ old('job_title_id', $data->job_title_id ?? '') == $job_title->id ? 'selected' : '' }}>
                        {{ $job_title->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

{{-- أسعار الكشف --}}
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="clinic_fees">سعر الكشف<span class="text-danger">*</span></label>
            <input class="form-control" id="clinic_fees" name="clinic_fees"
                value="{{ old('clinic_fees', $data->clinic_fees ?? '') }}" type="text" placeholder="سعر الكشف">
            @error('clinic_fees')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="clinic_fees_again">سعر إعادة الكشف</label>
            <input class="form-control" id="clinic_fees_again" name="clinic_fees_again"
                value="{{ old('clinic_fees_again', $data->clinic_fees_again ?? '') }}" type="text"
                placeholder="سعر إعادة الكشف">
            @error('clinic_fees_again')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="urgent_fees">سعر الكشف المستعجل</label>
            <input class="form-control" id="urgent_fees" name="urgent_fees"
                value="{{ old('urgent_fees', $data->urgent_fees ?? '') }}" type="text"
                placeholder="سعر الكشف المستعجل">
            @error('urgent_fees')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="urgent_fees_again">سعر إعادة الكشف المستعجل</label>
            <input class="form-control" id="urgent_fees_again" name="urgent_fees_again"
                value="{{ old('urgent_fees_again', $data->urgent_fees_again ?? '') }}" type="text"
                placeholder="سعر إعادة الكشف المستعجل">
            @error('urgent_fees_again')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

{{-- الزيارات المنزلية --}}
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="is_available_for_home_visits">متاح للزيارات المنزلية<span class="text-danger">*</span></label>
            <select class="form-control" id="is_available_for_home_visits" name="is_available_for_home_visits">
                <option value="1"
                    {{ old('is_available_for_home_visits', $data->is_available_for_home_visits ?? '') == '1' ? 'selected' : '' }}>
                    نعم</option>
                <option value="0"
                    {{ old('is_available_for_home_visits', $data->is_available_for_home_visits ?? '') == '0' ? 'selected' : '' }}>
                    لا</option>
            </select>
            @error('is_available_for_home_visits')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="home_visit_fees">سعر زيارة المنزل</label>
            <input class="form-control" id="home_visit_fees" name="home_visit_fees"
                value="{{ old('home_visit_fees', $data->home_visit_fees ?? '') }}" type="text"
                placeholder="سعر الزيارة المنزلية">
            @error('home_visit_fees')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="home_visit_fees_again">سعر إعادة زيارة المنزل</label>
            <input class="form-control" id="home_visit_fees_again" name="home_visit_fees_again"
                value="{{ old('home_visit_fees_again', $data->home_visit_fees_again ?? '') }}" type="text"
                placeholder="سعر إعادة الزيارة المنزلية">
            @error('home_visit_fees_again')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

{{-- روابط التواصل الاجتماعي والشروط --}}
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="facebook_url">رابط صفحة الفيسبوك (ان وجد)</label>
            <input class="form-control" id="facebook_url" name="facebook_url"
                value="{{ old('facebook_url', $data->facebook_url ?? '') }}" type="text"
                placeholder="رابط صفحة الفيسبوك (ان وجد)">
            @error('facebook_url')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="instagram_url">رابط صفحة الانستاجرام (ان وجد)</label>
            <input class="form-control" id="instagram_url" name="instagram_url"
                value="{{ old('instagram_url', $data->instagram_url ?? '') }}" type="text"
                placeholder="رابط صفحة الانستاجرام (ان وجد)">
            @error('instagram_url')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="is_accept_terms">موافقة على الشروط والاحكام<span class="text-danger">*</span><span class="text-danger" style="font-size: 8px;">
    (خاصة بالإدارة ولن يتم عرضها للمرضى)
</span></label>
            <select class="form-control" id="is_accept_terms" name="is_accept_terms">
                <option value="1"
                    {{ old('is_accept_terms', $data->is_accept_terms ?? '') == '1' ? 'selected' : '' }}>
                    نعم</option>
                <option value="0"
                    {{ old('is_accept_terms', $data->is_accept_terms ?? '') == '0' ? 'selected' : '' }}>
                    لا</option>
            </select>
            @error('is_accept_terms')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

{{-- الصور الشخصية والوثائق --}}
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="personal_image">صورة شخصيه<span class="text-danger">*</span></label>
            <input class="form-control" id="personal_image" name="personal_image" type="file" accept="image/*">
            @error('personal_image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <span class="text-danger" id="imageError" style="display: none;"></span>
            <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>

            @if (isset($data) && $data->personal_image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $data->personal_image) }}" alt="صورة شخصية"
                        class="img-thumbnail" style="max-width: 100px;">
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="logo">اللوجو<span class="text-danger">*</span></label>
            <input class="form-control" id="logo" name="logo" type="file" accept="image/*">
            @error('logo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <span class="text-danger" id="imageError" style="display: none;"></span>
            <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>

            @if (isset($data) && $data->logo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $data->logo) }}" alt="اللوجو" class="img-thumbnail"
                        style="max-width: 100px;">
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="id_image_front">صورة البطاقه الاماميه<span class="text-danger">*</span><span class="text-danger" style="font-size: 8px;">
    (خاصة بالإدارة ولن يتم عرضها للمرضى)
</span></label>
            <input class="form-control" id="id_image_front" name="id_image_front" type="file" accept="image/*">
            @error('id_image_front')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <span class="text-danger" id="imageError" style="display: none;"></span>
            <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>

            @if (isset($data) && $data->id_image_front)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $data->id_image_front) }}" alt="البطاقة الأمامية"
                        class="img-thumbnail" style="max-width: 100px;">
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="id_image_back">صورة البطاقه الخلفيه<span class="text-danger">*</span><span class="text-danger" style="font-size: 8px;">
    (خاصة بالإدارة ولن يتم عرضها للمرضى)
</span></label>
            <input class="form-control" id="id_image_back" name="id_image_back" type="file" accept="image/*">
            @error('id_image_back')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <span class="text-danger" id="imageError" style="display: none;"></span>
            <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>

            @if (isset($data) && $data->id_image_back)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $data->id_image_back) }}" alt="البطاقة الخلفية"
                        class="img-thumbnail" style="max-width: 100px;">
                </div>
            @endif
        </div>
    </div>
</div>

{{-- شهادات --}}
<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="graduation_certificate">شهادة التخرج<span class="text-danger">*</span><span class="text-danger" style="font-size: 8px;">
    (خاصة بالإدارة ولن يتم عرضها للمرضى)
</span></label>
            <input class="form-control" id="graduation_certificate" name="graduation_certificate" type="file"
                accept="image/*">
            @error('graduation_certificate')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <span class="text-danger" id="imageError" style="display: none;"></span>
            <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>

            @if (isset($data) && $data->graduation_certificate)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $data->graduation_certificate) }}" alt="شهادة التخرج"
                        class="img-thumbnail" style="max-width: 100px;">
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="professional_license">شهادة مزاولة المهنه<span class="text-danger">*</span><span class="text-danger" style="font-size: 8px;">
    (خاصة بالإدارة ولن يتم عرضها للمرضى)
</span></label>
            <input class="form-control" id="professional_license" name="professional_license" type="file"
                accept="image/*">
            @error('professional_license')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <span class="text-danger" id="imageError" style="display: none;"></span>
            <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>

            @if (isset($data) && $data->professional_license)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $data->professional_license) }}" alt="شهادة مزاولة المهنة"
                        class="img-thumbnail" style="max-width: 100px;">
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label for="syndicate_card">كارنية النقابة<span class="text-danger">*</span><span class="text-danger" style="font-size: 8px;">
    (خاصة بالإدارة ولن يتم عرضها للمرضى)
</span></label>
            <input class="form-control" id="syndicate_card" name="syndicate_card" type="file" accept="image/*">
            @error('syndicate_card')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <span class="text-danger" id="imageError" style="display: none;"></span>
            <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>

            @if (isset($data) && $data->syndicate_card)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $data->syndicate_card) }}" alt="كارنية النقابة"
                        class="img-thumbnail" style="max-width: 100px;">
                </div>
            @endif
        </div>
    </div>
</div>

{{-- صور المنظمة --}}
<div class="form-group">
    <label for="photo" class="form-label">صور للمنظمه</label>

    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo[]"
        multiple accept="image/*">
    @error('photo[]')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror

    @if (isset($data->images) && $data->images->count() > 0)
        <div class="mt-3">
            <label class="form-label">الصور الحالية:</label>
            <div class="row">
                @foreach ($data->images as $image)
                    <div class="col-md-3 mb-3">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $image->photo) }}" alt="Organization Photo"
                                class="img-thumbnail" style="max-width: 300px; max-height: 200px;">
                            <button type="button" class="btn btn-danger btn-sm position-absolute"
                                style="top: 5px; right: 5px;" onclick="deleteImage({{ $image->id }})">
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
