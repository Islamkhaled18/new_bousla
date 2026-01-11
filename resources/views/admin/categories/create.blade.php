@extends('layouts.admin.app')
@section('title')
    انشاء قسم جديد
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> الاقسام </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}" title="الاقسام">الاقسام</a></li>

                <li class="breadcrumb-item active"><a href="{{ route('categories.create') }}" title="انشاء قسم جديد">إانشاء
                        قسم جديد</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="col-lg-6">
                            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data"
                                id="categoryForm">
                                @csrf

                                <div class="form-group">
                                    <label for="exampleInputEmail1"> اسم القسم</label>
                                    <input class="form-control" id="exampleInputEmail1" name="name"
                                        value="{{ old('name') }}" type="text" placeholder="اسم القسم">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1"> اسم القسم بالانجليزية</label>
                                    <input class="form-control" id="exampleInputEmail1" name="name_en"
                                        value="{{ old('name_en') }}" type="text" placeholder="اسم القسم بالانجليزية">
                                    @error('name_en')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row" style="display:none" id="cats_list">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="projectinput1">
                                                القسم التابع
                                            </label>
                                            <select name="parent_id" class="select2 form-group">
                                                <optgroup label="اختر القسم">
                                                    @if ($categories && $categories->count() > 0)
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">
                                                                {{ $category->name }}</option>
                                                        @endforeach
                                                    @endif

                                                </optgroup>
                                            </select>
                                            @error('parent_id')
                                                <span class="text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="image">صورة القسم</label>
                                    <input class="form-control" id="image" name="image" type="file"
                                        accept="image/*">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <span class="text-danger" id="imageError" style="display: none;"></span>
                                    <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mt-1">
                                        <input type="radio" name="type" value="1" class="switchery"
                                            data-color="success" />
                                        <label class="card-title ml-1">القسم الرئيسي</label>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mt-1">
                                        <input type="radio" name="type" value="2" class="switchery"
                                            data-color="success" />
                                        <label class="card-title ml-1">القسم التابع</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="projectinput1">
                                                القسم الرئيسي
                                            </label>
                                            <select name="main_category_id" class="select2 form-group">
                                                <optgroup label="اختر القسم الرئيسي">
                                                    @if ($mainCategories && $mainCategories->count() > 0)
                                                        @foreach ($mainCategories as $mainCategory)
                                                            <option value="{{ $mainCategory->id }}">
                                                                {{ $mainCategory->name }}</option>
                                                        @endforeach
                                                    @endif

                                                </optgroup>
                                            </select>
                                            @error('main_category_id')
                                                <span class="text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
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
        $('input:radio[name="type"]').change(
            function() {
                if (this.checked && this.value == '2') { // قسم تابع
                    $('#cats_list').css('display', 'block');
                    $('select[name="parent_id"]').prop('disabled', false);
                } else {
                    $('#cats_list').css('display', 'none');

                    $('select[name="parent_id"]').val('').prop('disabled', true).trigger('change');
                }
            });


        $(document).ready(function() {
            var selectedType = $('input:radio[name="type"]:checked').val();
            if (selectedType == '1') {
                $('#cats_list').css('display', 'none');
                $('select[name="parent_id"]').val('').prop('disabled', true).trigger('change');
            } else if (selectedType == '2') {
                $('#cats_list').css('display', 'block');
                $('select[name="parent_id"]').prop('disabled', false);
            }
        });
    </script>
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
