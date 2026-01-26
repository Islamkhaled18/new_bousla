@extends('layouts.admin.app')
@section('title')
    عرض بيانات العميل -- {{ $client->full_name }}
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> بيانات العميل </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('clients.index') }}" title="بيانات العميل">العملاء</a></li>
                بيانات العميل </a></li>
                <li class="breadcrumb-item active"><a href="#" title="عرض بيانات العميل">عرض بيانات العميل</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="first_name">الاسم الاول</label>
                                    <input class="form-control" id="first_name" name="first_name" readonly
                                        value="{{ old('first_name', $client->first_name) }}" type="text"
                                        placeholder="اكتب الاسم الاول">

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="last_name">الاسم الثاني</label>
                                    <input class="form-control" id="last_name" name="last_name" readonly
                                        value="{{ old('last_name', $client->last_name) }}" type="text"
                                        placeholder="اكتب الاسم الثاني">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone">الهاتف</label>
                                    <input class="form-control" id="phone" name="phone" readonly
                                        value="{{ old('phone', $client->phone) }}" type="text" placeholder="اكتب الهاتف">

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="address">العنوان</label>
                                    <input class="form-control" id="address" name="address" readonly
                                        value="{{ old('address', $client->address) }}" type="text"
                                        placeholder="اكتب العنوان">

                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">البريد الالكتروني</label>
                                    <input class="form-control" id="email" name="email" readonly
                                        value="{{ old('email', $client->email) }}" type="text"
                                        placeholder="اكتب البريد الالكتروني
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="personal_image">صورة شخصيه</label>
                                    <span class="text-danger" id="imageError" style="display: none;"></span>
                                    <small class="form-text text-muted">الحد الأقصى لحجم الصورة: 5 ميجابايت</small>
                                    @if ($client->personal_image)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $client->personal_image) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $client->personal_image) }}"
                                                    alt="Personal Image" class="img-thumbnail"
                                                    style="max-width: 150px; cursor: pointer;">
                                            </a>
                                            <p class="text-muted small">الصورة الحالية (اضغط للعرض بحجم كامل)</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
