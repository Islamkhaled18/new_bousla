@extends('layouts.admin.app')
@section('title')
    احصائيات الاطباء
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i>احصائيات الاطباء </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>

                <li class="breadcrumb-item active"><a href="{{ route('statistices.index') }}" title="احصائيات الاطباء">احصائيات
                        الاطباء</a></li>

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
                                    <th>عدد اضافتهم للمفضله</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doctors as $doctor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $doctor->full_name }}</td>
                                        <td>{{ $doctor->phone }}</td>
                                        <td>{{ $doctor->favorited_by_count }}</td>
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