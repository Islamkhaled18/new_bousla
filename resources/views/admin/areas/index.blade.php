@extends('layouts.admin.app')
@section('title')
    المناطق
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i>المناطق </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item active"><a href="{{ route('areas.index') }}" title="المناطق">المناطق</a>
                </li>
            </ul>
        </div>
        <div>
            <a class="btn btn-primary btn-sm" href="{{ route('areas.create') }}" title="انشاء منطقه جديده">انشاء منطقه
                جديده</a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>المحافظه</th>
                                    <th>المدينه</th>
                                    <th>المنطقه</th>
                                    <th>المنطقه بالانجليزية</th>
                                    <th>الحالة</th>
                                    <th>العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($areas as $area)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $area->city->governorate->name ?? '--' }}</td>
                                        <td>{{ $area->city->name }}</td>
                                        <td>{{ $area->name }}</td>
                                        <td>{{ $area->name_en ?? '-' }}</td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <input class="status-toggle" type="checkbox" id="status_{{ $area->id }}"
                                                    data-slug="{{ $area->slug }}" {{ $area->is_active ? 'checked' : '' }}
                                                    style="width: 45px; height: 22px; cursor: pointer;">
                                                <span
                                                    class="badge {{ $area->is_active ? 'badge-success' : 'badge-danger' }}"
                                                    style="font-size: 13px; padding: 5px 10px;">
                                                    {{ $area->is_active ? 'نشط' : 'غير نشط' }}
                                                </span>
                                            </div>


                                            {{-- <span class="badge {{ $area->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $area->is_active ? 'نشط' : 'غير نشط' }}
                                    </span> --}}
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-dark" href="{{ route('areas.edit', $area) }}"
                                                title="تعديل">تعديل</a>

                                            <form action="{{ route('areas.destroy', $area) }}" title="حذف"
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

        $('.status-toggle').change(function() {
            let checkbox = $(this);
            let slug = checkbox.data('slug');
            let isActive = checkbox.is(':checked') ? 1 : 0;

            checkbox.prop('disabled', true);

            $.ajax({
                url: '{{ route('areas.toggle-status', ':slug') }}'.replace(':slug', slug),
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
