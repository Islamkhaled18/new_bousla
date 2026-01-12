@extends('layouts.admin.app')
@section('title')
    الاقسام
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> الاقسام </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item active"><a href="{{ route('categories.index') }}" title="الاقسام">الاقسام</a></li>
            </ul>
        </div>
        <div>
            <a class="btn btn-primary btn-sm" href="{{ route('categories.create') }}" title="انشاء قسم جديد">انشاء قسم
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
                                    <th>اسم القسم</th>
                                    <th>اسم القسم بالانجليزية</th>
                                    <th>اسم القسم التابع</th>
                                    <th>صورة القسم</th>
                                    <th>القسم الرئيسي</th>
                                    <th>الحالة</th>
                                    <th>العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->name_en ?? '-' }}</td>
                                        <td>{{ $category->_parent->name ?? '--' }}</td>
                                        <td><img src="{{ $category->image_url }}" title="{{ $category->name }}"
                                                alt="{{ $category->name }}" width="60" height="60" alt="">
                                        </td>
                                        <td>{{ $category->MainCategory->name ?? '--' }}</td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <input class="status-toggle" type="checkbox"
                                                    id="status_{{ $category->id }}" data-slug="{{ $category->slug }}"
                                                    {{ $category->is_active ? 'checked' : '' }}
                                                    style="width: 45px; height: 22px; cursor: pointer;">
                                                <span
                                                    class="badge {{ $category->is_active ? 'badge-success' : 'badge-danger' }}"
                                                    style="font-size: 13px; padding: 5px 10px;">
                                                    {{ $category->is_active ? 'نشط' : 'غير نشط' }}
                                                </span>
                                            </div>

                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-dark" href="{{ route('categories.edit', $category) }}"
                                                title="تعديل">تعديل</a>

                                            <form action="{{ route('categories.destroy', $category) }}" method="post"
                                                style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="'submit" title="حذف"
                                                    class="btn btn-danger delete btn-sm"><i
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

        $('.status-toggle').change(function() {
            let checkbox = $(this);
            let slug = checkbox.data('slug');
            let isActive = checkbox.is(':checked') ? 1 : 0;

            checkbox.prop('disabled', true);

            $.ajax({
                url: '{{ route('categories.toggle-status', ':slug') }}'.replace(':slug', slug),
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
