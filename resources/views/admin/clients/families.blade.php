@extends('layouts.admin.app')
@section('title')
    افراد العائلة
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i>افراد العائلة </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('clients.index') }}" title="العملاء">العملاء</a>
                </li>
                <li class="breadcrumb-item active"><a href="#"
                        title="افراد العائلة ">افراد
                        العائلة </a></li>

            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم بالكامل</th>
                                    <th>رقم الهاتف</th>
                                    <th>صلة القرابه</th>
                                    <th>العمر</th>
                                    <th>الجنس</th>
                                    <th>فصيلة الدم</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($families as $family)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $family->name }}</td>
                                        <td>{{ $family->phone }}</td>
                                        <td>{{ $family->relationship }}</td>
                                        <td>{{ $family->age }}</td>
                                        <td>{{ $family->gender == 'male' ? 'ذكر' : 'أنثى' }}</td>
                                        <td>{{ $family->blood_type ?? 'لا يوجد'}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
