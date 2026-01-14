@extends('layouts.admin.app')
@section('title')
    بيانات المشرف
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

                <li class="breadcrumb-item active"><a href="{{ route('admins.show', $admin) }}" title=" بيانات المشرف">
                        بيانات المشرف</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="col-12">


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>الاسم <span class="tx-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" readonly
                                            value="{{ old('name', $admin->name) }}" placeholder="اكتب الاسم">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>البريد الالكتروني <span class="tx-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" readonly
                                            value="{{ old('email', $admin->email) }}" placeholder="اكتب البريد الالكتروني">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mg-b-20">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>صلاحية المستخدم <span class="tx-danger">*</span></label>
                                        <select name="roles_name[]" class="form-control" multiple readonly>
                                            @foreach ($roles as $key => $role)
                                                <option value="{{ $key }}"
                                                    {{ in_array($key, $adminRoles) ? 'selected' : '' }}>
                                                    {{ $role }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('roles_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </main>
@endsection
