@extends('layouts.admin.app')
@section('title')
    تعديل محافظة - {{ $governorate->name }}
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> المحافظات </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('governorates.index') }}" title="المحافظات">المحافظات</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('governorates.edit', $governorate) }}"
                        title="تعديل على المحافظة">تعديل على المحافظة -
                        {{ $governorate->name }}</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="tile">
                    <div class="tile-body">
                        <div class="col-lg-6">
                            <form action="{{ route('governorates.update', $governorate) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <input name="id" value="{{ $governorate->id }}" type="hidden">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">الاسم</label>
                                    <input class="form-control" id="exampleInputEmail1" name="name"
                                        value="{{ $governorate->name }}" type="text" placeholder="اكتب اسم المحافظة">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">الاسم بالانحليزية</label>
                                    <input class="form-control" id="exampleInputEmail1" name="name_en"
                                        value="{{ $governorate->name_en }}" type="text"
                                        placeholder="اكتب اسم المحافظة بالانجليزية">
                                    @error('name_en')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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
