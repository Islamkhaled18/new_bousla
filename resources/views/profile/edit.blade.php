@extends('layouts.admin.app')
@section('title')
    تعديل بياناتك الشخصيه
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> البروفايل </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>

                <li class="breadcrumb-item active"><a href="{{ route('profile.edit') }}"
                        title="تعديل بياناتك الشخصيه">تعديل بياناتك الشخصيه
                         </a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="col-12">
                            <form action="{{ route('profile.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>الاسم الاول <span class="tx-danger">*</span></label>
                                            <input type="text" name="first_name" class="form-control"
                                                value="{{ old('first_name', $user->first_name) }}"
                                                placeholder="اكتب الاسم الاول">
                                            @error('first_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>الاسم الثاني <span class="tx-danger">*</span></label>
                                            <input type="text" name="last_name" class="form-control"
                                                value="{{ old('last_name', $user->last_name) }}"
                                                placeholder="اكتب الاسم الثاني">
                                            @error('last_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>البريد الالكتروني <span class="tx-danger">*</span></label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email', $user->email) }}"
                                                placeholder="اكتب البريد الالكتروني">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>الهاتف <span class="tx-danger">*</span></label>
                                            <input type="text" name="phone" class="form-control"
                                                value="{{ old('phone', $user->phone) }}"
                                                placeholder="اكتب الهاتف">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> إذا كنت تريد تغيير كلمة المرور، يجب عليك إدخال
                                            كلمة المرور القديمة أولاً
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>كلمة المرور القديمة</label>
                                            <input type="password" name="current_password" class="form-control"
                                                placeholder="كلمة المرور القديمة">
                                            @error('current_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>كلمة المرور الجديدة</label>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="كلمة المرور الجديدة">
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>تأكيد كلمة المرور الجديدة</label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="تأكيد كلمة المرور الجديدة">
                                            @error('password_confirmation')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="row mg-b-20">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>صلاحية المستخدم <span class="tx-danger">*</span></label>
                                            <select name="roles_name[]" class="form-control" multiple>
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
                                </div> --}}

                                <div class="tile-footer">
                                    <button class="btn btn-primary" type="submit">تحديث</button>
                                    <a href="{{ route('profile.edit') }}" class="btn btn-secondary">إلغاء</a>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </main>
@endsection
