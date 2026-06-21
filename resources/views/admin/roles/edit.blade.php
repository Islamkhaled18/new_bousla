@extends('layouts.admin.app')

@section('title')
    @lang('role.edit_role')
@endsection

@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> @lang('role.roles') </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a></li>
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}"
                        title="@lang('role.roles')">@lang('role.roles')</a></li>
                <li class="breadcrumb-item active"><a href="#" title="@lang('role.edit_role')">@lang('role.edit_role')</a></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="col-12">
                            <form action="{{ route('roles.update', $role->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('role.role_name') <span class="text-danger">*</span></label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name', $role->name) }}" placeholder="@lang('role.role_name')">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mg-b-20">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>@lang('role.permissions') <span class="text-danger">*</span></label>

                                            <div class="mb-2">
                                                <button type="button" class="btn btn-sm btn-primary" id="select-all">
                                                    <i class="fa fa-check"></i> @lang('main.select_all')
                                                </button>
                                                <button type="button" class="btn btn-sm btn-secondary" id="deselect-all">
                                                    <i class="fa fa-times"></i> @lang('main.deselect_all')
                                                </button>
                                            </div>

                                            <div class="permissions-container"
                                                style="border: 1px solid #ddd; padding: 15px; border-radius: 4px; max-height: 300px; overflow-y: auto;">
                                                @foreach ($permissions as $permission)
                                                    <div class="form-check"
                                                        style="margin-bottom: 25px; display: table; width: 100%;">
                                                        <input type="checkbox" name="permission[]"
                                                            value="{{ $permission->id }}"
                                                            class="form-check-input permission-checkbox"
                                                            id="permission_{{ $permission->id }}"
                                                            style="display: table-cell; width: 20px; vertical-align: middle;"
                                                            {{ in_array($permission->id, old('permission', $rolePermissions)) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="permission_{{ $permission->id }}"
                                                            style="display: table-cell; font-size: 16px; cursor: pointer; padding-right: 15px; vertical-align: middle;">
                                                            {{ __('permission.' . $permission->name) }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('permission')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="tile-footer">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-save"></i> @lang('main.save')
                                    </button>
                                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-times"></i> @lang('main.cancel')
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Select All Permissions
                document.getElementById('select-all').addEventListener('click', function() {
                    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                        checkbox.checked = true;
                    });
                });

                // Deselect All Permissions
                document.getElementById('deselect-all').addEventListener('click', function() {
                    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                });
            });
        </script>
    @endpush
@endsection
