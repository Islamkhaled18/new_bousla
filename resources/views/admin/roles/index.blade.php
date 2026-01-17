@extends('layouts.admin.app')
@section('title')
    الدور
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i>الدور </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>

                <li class="breadcrumb-item active"><a href="{{ route('roles.index') }}" title="الدور">الدور</a></li>

            </ul>
        </div>
        <div>
            <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}" title="انشاء دور جديد">انشاء دور
                جديد</a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم الدور</th>
                                    <th>العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-dark" href="{{ route('roles.edit', $role) }}"
                                                title="تعديل">تعديل</a>

                                            <a class="btn btn-sm btn-info" href="{{ route('roles.show', $role) }}"
                                                title="عرض">عرض</a>

                                            <form action="{{ route('roles.destroy', $role) }}" title="حذف"
                                                method="post" style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="'submit" class="btn btn-danger delete btn-sm"><i
                                                        class="fa fa-trash"></i>حذف</button>
                                            </form>
                                        </td>
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