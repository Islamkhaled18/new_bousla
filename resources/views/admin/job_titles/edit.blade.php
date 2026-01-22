@extends('layouts.admin.app')
@section('title')
    تعديل وظيفه - {{ $job_title->name }}
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> الوظائف </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('job-titles.index') }}" title="الوظائف">الوظائف</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('job-titles.edit', $job_title) }}"
                        title="تعديل على وظيفه">تعديل على وظيفه -
                        {{ $job_title->name }}</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="tile">
                    <div class="tile-body">
                        <div class="col-lg-6">
                            <form action="{{ route('job-titles.update', $job_title) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">الاسم</label>
                                    <input class="form-control" id="name" name="name"
                                        value="{{ old('name', $job_title->name) }}" type="text" placeholder="اكتب الاسم">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="name_en">الاسم بالانجليزية</label>
                                    <input class="form-control" id="name_en" name="name_en"
                                        value="{{ old('name_en', $job_title->name_en) }}" type="text"
                                        placeholder="اكتب الاسم بالانجليزية">
                                    @error('name_en')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="icon">الأيقونة (Font Awesome Class)</label>
                                    <input class="form-control" id="icon" name="icon" 
                                        value="{{ old('icon', $job_title->icon) }}"
                                        type="text" placeholder="مثال: fa-stethoscope">
                                    <small class="form-text text-muted">اكتب اسم الأيقونة من Font Awesome مثل: fa-heart, fa-user-doctor</small>
                                    @error('icon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="icon_color">لون الأيقونة</label>
                                    <input class="form-control" id="icon_color" name="icon_color" 
                                        value="{{ old('icon_color', $job_title->icon_color) }}"
                                        type="color">
                                    @error('icon_color')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="bg_color">لون الخلفية</label>
                                    <input class="form-control" id="bg_color" name="bg_color" 
                                        value="{{ old('bg_color', $job_title->bg_color) }}"
                                        type="color">
                                    @error('bg_color')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>معاينة الأيقونة</label>
                                    <div id="icon-preview" style="display: inline-flex; align-items: center; justify-content: center; 
                                        width: 60px; height: 60px; border-radius: 8px; 
                                        background-color: {{ $job_title->bg_color }};">
                                        <i class="fas {{ $job_title->icon }}" 
                                           style="font-size: 28px; color: {{ $job_title->icon_color }};"></i>
                                    </div>
                                </div>

                                <div class="tile-footer">
                                    <button class="btn btn-primary" type="submit">تعديل</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('scripts')
<script>
    // معاينة الأيقونة مباشرة
    function updateIconPreview() {
        let icon = $('#icon').val() || 'fa-question';
        let iconColor = $('#icon_color').val() || '#00B6B0';
        let bgColor = $('#bg_color').val() || '#E6F7F6';
        
        $('#icon-preview').css('background-color', bgColor);
        $('#icon-preview i').attr('class', 'fas ' + icon).css('color', iconColor);
    }

    $('#icon, #icon_color, #bg_color').on('input change', updateIconPreview);
</script>
@endpush