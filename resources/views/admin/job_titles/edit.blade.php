@extends('layouts.admin.app')
@section('title')
تعديل وظيفه
@endsection
@section('content')
<main class="app sidebar-mini rtl">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> الوظائف </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('job-titles.index') }}"
                    title="الوظائف">الوظائف</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('job-titles.edit', $job_title) }}"
                    title="تعديل على وظيفه">تعديل على وظيفه -
                    {{ $job_title->name }}</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tile">
                <div class="tile-body">
                    <div class="col-lg-6">
                        <form action="{{ route('job-titles.update', $job_title) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input name="id" value="{{ $job_title->id }}" type="hidden">

                            <div class="form-group">
                                <label for="exampleInputEmail1">الاسم</label>
                                <input class="form-control" id="exampleInputEmail1" name="name"
                                    value="{{ $job_title->name }}" type="text" placeholder="اكتب الاسم">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">الاسم بالانحليزية</label>
                                <input class="form-control" id="exampleInputEmail1" name="name_en"
                                    value="{{ $job_title->name_en }}" type="text" placeholder="اكتب الاسم بالانجليزية">
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
