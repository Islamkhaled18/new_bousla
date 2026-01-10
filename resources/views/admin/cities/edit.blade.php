@extends('layouts.admin.app')
@section('title')
تعديل مدينه - {{ $city->name }}
@endsection
@section('content')
<main class="app sidebar-mini rtl">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> المدن </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('cities.index') }}"
                    title="المدن">المدن</a></li>
       
            <li class="breadcrumb-item active"><a href="{{ route('cities.edit', $city) }}"
                    title="تعديل على مدينه">تعديل على مدينه -
                    {{ $city->name }}</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tile">
                <div class="tile-body">
                    <div class="col-lg-6">
                        <form action="{{ route('cities.update', $city) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input name="id" value="{{ $city->id }}" type="hidden">

                            <div class="form-group">
                                <label for="exampleInputEmail1">الاسم</label>
                                <input class="form-control" id="exampleInputEmail1" name="name"
                                    value="{{ $city->name }}" type="text" placeholder="اكتب الاسم">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">الاسم بالانجليزية</label>
                                <input class="form-control" id="exampleInputEmail1" name="name_en"
                                    value="{{ $city->name_en }}" type="text" placeholder="اكتب الاسم">
                                @error('name_en')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">المحافظه </label>
                                <select class="form-control" id="exampleInputEmail1" name="governorate_id">
                                    @foreach ($governorates as $governorate)
                                    <option value="{{$governorate->id}}">{{$governorate->name}}</option>
                                    @endforeach
                                </select>
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
