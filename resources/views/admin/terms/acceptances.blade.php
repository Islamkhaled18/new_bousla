@extends('layouts.admin.app')
@section('title')
    الموافقون على الشروط والاحكام
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> الموافقون على الشروط والاحكام </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item active"><a href="{{ route('terms.index') }}" title="الموافقون على الشروط والاحكام">
                    الموافقون على الشروط والاحكام</a></li>
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
                                    <th>محتوى الشروط والاحكام</th>
                                    <th>الاصدار</th>
                                    <th>المستخدم</th>
                                    <th>تاريخ القبول</th>
                                    <th>ال IP</th>
                                    <th>معلومات المتصفح</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($acceptances as $acceptance)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{!! Str::limit($acceptance->termCondition->name, 100) !!}</td>
                                        <td>{{ $acceptance->termCondition->version }}</td>
                                        <td>{{ $acceptance->user->full_name }}</td>
                                        <td>{{ $acceptance->accepted_at->format('Y-m-d H:i:s') }}</td>
                                        <td>{{ $acceptance->ip_address }}</td>
                                        <td>{{ $acceptance->user_agent }}</td>
                                        
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

