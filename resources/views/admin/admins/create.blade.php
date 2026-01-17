@extends('layouts.admin.app')
@section('title')
    انشاء مشرف جديد
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> المشرفين </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>

                <li class="breadcrumb-item"><a href="{{ route('admins.index') }}" title="المشرفين">المشرفين</a></li>

                <li class="breadcrumb-item active"><a href="{{ route('admins.create') }}" title="انشاء مشرف جديد">إانشاء
                        مشرف جديد</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="col-12">
                            <form action="{{ route('admins.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>الاسم الاول <span class="tx-danger">*</span></label>
                                            <input type="text" name="first_name" class="form-control"
                                                value="{{ old('first_name') }}" placeholder="اكتب الاسم الاول">
                                            @error('first_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>الاسم التاني <span class="tx-danger">*</span></label>
                                            <input type="text" name="last_name" class="form-control"
                                                value="{{ old('last_name') }}" placeholder="اكتب الاسم التاني">
                                            @error('last_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>البريد الالكتروني <span class="tx-danger">*</span></label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email') }}" placeholder="اكتب البريد الالكتروني">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> الهاتف <span class="tx-danger">*</span></label>
                                            <input type="text" name="phone" class="form-control"
                                                value="{{ old('phone') }}" placeholder="اكتب رقم الهاتف">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>كلمة المرور <span class="tx-danger">*</span></label>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="كلمة المرور">
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>تأكيد كلمة المرور <span class="tx-danger">*</span></label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="تأكيد كلمة المرور">
                                            @error('password_confirmation')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mg-b-20">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>صلاحية المستخدم <span class="tx-danger">*</span></label>
                                            <select name="roles_name[]" class="form-control" multiple>
                                                @foreach ($roles as $key => $role)
                                                    <option value="{{ $key }}">{{ $role }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="tile-footer">
                                    <button class="btn btn-primary" type="submit">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </main>
@endsection
