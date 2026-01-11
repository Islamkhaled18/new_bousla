@extends('layouts.admin.app')
@section('title')
    تعديل قسم رئيسي
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> الاقسم الرئيسيه </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('main-categories.index') }}" title="الاقسام الرئيسيه">الاقسام
                        الرئيسيه</a></li>

                <li class="breadcrumb-item active"><a href="{{ route('main-categories.edit', $main_category) }}"
                        title="تعديل على قسم رئيسي">تعديل على قسم رئيسي -
                        {{ $main_category->name }}</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="tile">
                    <div class="tile-body">
                        <div class="col-lg-6">
                            <form action="{{ route('main-categories.update', $main_category) }}" method="POST"
                                enctype="multipart/form-data" id="categoryForm">
                                @csrf
                                @method('PUT')

                                <input name="id" value="{{ $main_category->id }}" type="hidden">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">الاسم</label>
                                    <input class="form-control" id="exampleInputEmail1" name="name"
                                        value="{{ $main_category->name }}" type="text" placeholder="اكتب الاسم">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">الاسم بالانجليزية</label>
                                    <input class="form-control" id="exampleInputEmail1" name="name_en"
                                        value="{{ $main_category->name_en }}" type="text"
                                        placeholder="اكتب الاسم بالانجليزية">
                                    @error('name_en')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="image" class="form-label">صورة القسم الرئيسي</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <div class="mt-2">
                                        <img src="{{ $main_category->image_url }}" class="d-block" width="60"
                                            height="60" alt="صورة القسم الحالية">
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <span class="text-danger" id="imageError" style="display: none;"></span>
                                    <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                </div>
                                <div class="tile-footer">
                                    <button class="btn btn-primary" type="submit" id="submitBtn">تعديل</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image');
        const imageError = document.getElementById('imageError');
        const form = document.getElementById('categoryForm');
        const submitBtn = document.getElementById('submitBtn');
        
        // التحقق من حجم الصورة عند اختيارها
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            imageError.style.display = 'none';
            imageError.textContent = '';
            
            if (file) {
                const fileSize = file.size / 1024 / 1024; // تحويل إلى ميجابايت
                
                if (fileSize > 5) {
                    imageError.textContent = `حجم الصورة (${fileSize.toFixed(2)} ميجابايت) أكبر من الحد المسموح (5 ميجابايت)`;
                    imageError.style.display = 'block';
                    imageInput.value = ''; // مسح الملف
                }
            }
        });
        
        // التحقق قبل إرسال الفورم
        form.addEventListener('submit', function(e) {
            const file = imageInput.files[0];
            
            if (file) {
                const fileSize = file.size / 1024 / 1024;
                
                if (fileSize > 5) {
                    e.preventDefault();
                    imageError.textContent = `حجم الصورة (${fileSize.toFixed(2)} ميجابايت) أكبر من الحد المسموح (5 ميجابايت)`;
                    imageError.style.display = 'block';
                    
                    // التمرير إلى رسالة الخطأ
                    imageError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return false;
                }
            }
        });
    });
</script>
@endpush