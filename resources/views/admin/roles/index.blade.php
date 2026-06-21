@extends('layouts.admin.app')
@section('title')
    @lang('role.roles')
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i>@lang('role.roles') </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>

                <li class="breadcrumb-item active"><a href="{{ route('roles.index') }}"
                        title="@lang('role.roles')">@lang('role.roles')</a></li>

            </ul>
        </div>
        <div>
            <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}"
                title="@lang('role.create_new_role')">@lang('role.create_new_role')</a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('role.role_name')</th>
                                    <th>@lang('main.actions')</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-dark" href="{{ route('roles.edit', $role) }}"
                                                title="@lang('main.edit')">@lang('main.edit')</a>

                                            <a class="btn btn-sm btn-info" href="{{ route('roles.show', $role) }}"
                                                title="@lang('main.show')">@lang('main.show')</a>

                                            <form action="{{ route('roles.destroy', $role) }}" title="@lang('main.delete')" method="post"
                                                style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="'submit" class="btn btn-danger delete btn-sm"><i
                                                        class="fa fa-trash"></i>@lang('main.delete')</button>
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
