@extends('layouts.admin.app')
@section('title')
    تعديل صورة اعلان
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> تعديل صورة اعلان </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('ads.index') }}" title="صور الاعلانات">صور الاعلانات</a>
                </li>

                <li class="breadcrumb-item active"><a href="{{ route('ads.edit', $ad) }}" title="تعديل على صورة اعلان">تعديل
                        على صورة اعلان -
                        {{ $ad->name }}</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="col-lg-6">
                            <form action="{{ route('ads.update', $ad) }}" method="POST" enctype="multipart/form-data"
                                id="adForm">
                                @csrf
                                @method('PUT')

                                <input name="id" value="{{ $ad->id }}" type="hidden">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">اسم الاعلان </label>
                                    <input class="form-control" id="exampleInputEmail1" name="name"
                                        value="{{ $ad->name }}" type="text" placeholder="اكتب اسم الاعلان ">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">اسم الاعلان باللغه الانجليزية </label>
                                    <input class="form-control" id="exampleInputEmail1" name="name_en"
                                        value="{{ $ad->name_en }}" type="text" placeholder="اكتب اسم الاعلان ">
                                    @error('name_en')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="start_date">تاريخ البداية</label>
                                    <input class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                                        name="start_date" type="date"
                                        value="{{ old('start_date', $ad->start_date ? \Carbon\Carbon::parse($ad->start_date)->format('Y-m-d') : '') }}">
                                    @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="end_date">تاريخ النهاية</label>
                                    <input class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                                        name="end_date" type="date"
                                        value="{{ old('end_date', $ad->end_date ? \Carbon\Carbon::parse($ad->end_date)->format('Y-m-d') : '') }}">
                                    @error('end_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="image" class="form-label">صورة الاعلان</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                        accept="image/*">
                                    <div class="mt-2">
                                        <img src="{{ $ad->image_url }}" class="d-block" width="60" height="60"
                                            alt="صورة القسم الحالية">
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
            const form = document.getElementById('adForm');
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
