@extends('layouts.admin.app')
@section('title')
    المشرفين
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i>المشرفين </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>

                <li class="breadcrumb-item active"><a href="{{ route('admins.index') }}" title="المشرفين">المشرفين</a></li>

            </ul>
        </div>
        <div>
            <a class="btn btn-primary btn-sm" href="{{ route('admins.create') }}" title="انشاء مشرف جديد">انشاء مشرف
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
                                    <th>اسم المشرف</th>
                                    <th>البريد الالكتروني</th>
                                    <th>رقم الهاتف</th>
                                    <th>الحالة</th>
                                    <th>نوع المستخدم</th>
                                    <th>العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $admin->full_name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->phone }}</td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                @if ($admin->id != auth()->id())
                                                    
                                                <input class="status-toggle" type="checkbox"
                                                id="status_{{ $admin->id }}" data-slug="{{ $admin->slug }}"
                                                {{ $admin->is_active ? 'checked' : '' }}
                                                style="width: 45px; height: 22px; cursor: pointer;">
                                                @endif
                                                <span
                                                    class="badge {{ $admin->is_active ? 'badge-success' : 'badge-danger' }}"
                                                    style="font-size: 13px; padding: 5px 10px;">
                                                    {{ $admin->is_active ? 'نشط' : 'غير نشط' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            @if (!empty($admin->getRoleNames()))
                                                @foreach ($admin->getRoleNames() as $role_name)
                                                    <label class="badge badge-success">{{ $role_name }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-dark" href="{{ route('admins.edit', $admin) }}"
                                                title="تعديل">تعديل</a>

                                            <a class="btn btn-sm btn-info" href="{{ route('admins.show', $admin) }}"
                                                title="عرض">عرض</a>

                                            <form action="{{ route('admins.destroy', $admin) }}" title="حذف"
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

@push('scripts')
    <script type="text/javascript">
        $('#sampleTable').DataTable();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.status-toggle').change(function() {
            let checkbox = $(this);
            let slug = checkbox.data('slug');
            let isActive = checkbox.is(':checked') ? 1 : 0;

            checkbox.prop('disabled', true);

            $.ajax({
                url: '{{ route('admins.toggle-status', ':slug') }}'.replace(':slug', slug),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    is_active: isActive
                },
                success: function(response) {
                    if (response.success) {
                        // Update badge
                        let badge = checkbox.closest('td').find('.badge');
                        if (isActive) {
                            badge.removeClass('badge-danger').addClass('badge-success').text('نشط');
                            toastr.success('تم التفعيل بنجاح');
                        } else {
                            badge.removeClass('badge-success').addClass('badge-danger').text('غير نشط');
                            toastr.info('تم إلغاء التفعيل');
                        }
                        checkbox.prop('disabled', false);
                    } else {
                        checkbox.prop('checked', !isActive);
                        checkbox.prop('disabled', false);
                        toastr.error('حدث خطأ');
                    }
                },
                error: function(xhr) {
                    checkbox.prop('checked', !isActive);
                    checkbox.prop('disabled', false);
                    toastr.error('فشل الاتصال بالخادم');
                }
            });
        });
    </script>
@endpush
