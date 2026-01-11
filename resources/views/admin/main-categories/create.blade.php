@extends('layouts.admin.app')
@section('title')
    انشاء قسم رئيسي جديد
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> الاقسام الرئيسية </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('main-categories.index') }}" title="الاقسام الرئيسية">الاقسام
                        الرئيسية</a></li>

                <li class="breadcrumb-item active"><a href="{{ route('main-categories.create') }}"
                        title="انشاء قسم رئيسي جديد">إانشاء قسم رئيسي جديد</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="col-lg-6">
                            <form action="{{ route('main-categories.store') }}" method="POST"
                                enctype="multipart/form-data" id="categoryForm">
                                @csrf

                                <div class="form-group">
                                    <label for="exampleInputEmail1">الاسم </label>
                                    <input class="form-control" id="exampleInputEmail1" name="name"
                                        value="{{ old('name') }}" type="text" placeholder="اكتب الاسم ">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">الاسم بالانجليزية </label>
                                    <input class="form-control" id="exampleInputEmail1" name="name_en"
                                        value="{{ old('name_en') }}" type="text" placeholder="اكتب الاسم بالانجليزية ">
                                    @error('name_en')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="image">صورة القسم الرئيسي</label>
                                    <input class="form-control" id="image" name="image" type="file"
                                        accept="image/*">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <span class="text-danger" id="imageError" style="display: none;"></span>
                                    <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                </div>

                                <div class="tile-footer">
                                    <button class="btn btn-primary" type="submit" id="submitBtn">حفظ</button>
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
                        imageError.textContent =
                            `حجم الصورة (${fileSize.toFixed(2)} ميجابايت) أكبر من الحد المسموح (5 ميجابايت)`;
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
                        imageError.textContent =
                            `حجم الصورة (${fileSize.toFixed(2)} ميجابايت) أكبر من الحد المسموح (5 ميجابايت)`;
                        imageError.style.display = 'block';

                        // التمرير إلى رسالة الخطأ
                        imageError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        return false;
                    }
                }
            });
        });
    </script>
@endpush

