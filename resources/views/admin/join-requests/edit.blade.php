@extends('layouts.admin.app')
@section('title')
    تعديل طلب الانضمام -- {{ $joinRequest->full_name }}
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> طلبات الانضمام </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('join-requests.index') }}" title="طلبات الانضمام">طلبات
                        الانضمام</a></li>
                <li class="breadcrumb-item active"><a href="#" title="تعديل طلب الانضمام">تعديل طلب الانضمام</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form action="{{ route('join-requests.update', $joinRequest) }}" method="POST"
                            enctype="multipart/form-data" id="joinRequestForm">
                            @csrf
                            @method('PUT')

                            {{-- Form Fields --}}
                            @include('admin.join-requests.parts.form-fields')

                            {{-- جدول مواعيد العمل --}}
                            @include('admin.join-requests.parts.doctor_schedules')

                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit" id="submitBtn">تحديث</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    @include('admin.join-requests.parts.image-validation')
    @include('admin.join-requests.parts.doctor-schedules-scripts')
@endpush