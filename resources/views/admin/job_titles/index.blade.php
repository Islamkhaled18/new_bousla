@extends('layouts.admin.app')
@section('title')
    الوظائف
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i>الوظائف </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>

                <li class="breadcrumb-item active"><a href="{{ route('job-titles.index') }}" title="الوظائف">الوظائف</a></li>

            </ul>
        </div>
        <div>
            <a class="btn btn-primary btn-sm" href="{{ route('job-titles.create') }}" title="انشاء وظيفه جديده">انشاء وظيفه
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
                                    <th>الوظيفه</th>
                                    <th>الوظيفه بالانجليزية</th>
                                    <th>الايقونه</th>
                                    <th>الحالة</th>
                                    <th>العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($job_titles as $job_title)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $job_title->name }}</td>
                                        <td>{{ $job_title->name_en }}</td>
                                        <td>
                                            <div
                                                style="display: inline-flex; align-items: center; justify-content: center; 
                width: 45px; height: 45px; border-radius: 8px; 
                background-color: {{ $job_title->bg_color }};">
                                                <i class="fas {{ $job_title->icon }}"
                                                    style="font-size: 20px; color: {{ $job_title->icon_color }};"></i>
                                            </div>
                                        </td>

                                        <td>
                                            {{-- @can('jobs.edit') --}}
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <input class="status-toggle" type="checkbox"
                                                    id="status_{{ $job_title->id }}" data-slug="{{ $job_title->slug }}"
                                                    {{ $job_title->is_active ? 'checked' : '' }}
                                                    style="width: 45px; height: 22px; cursor: pointer;">
                                                <span
                                                    class="badge {{ $job_title->is_active ? 'badge-success' : 'badge-danger' }}"
                                                    style="font-size: 13px; padding: 5px 10px;">
                                                    {{ $job_title->is_active ? 'نشط' : 'غير نشط' }}
                                                </span>
                                            </div>
                                            {{-- @else
                                    <span class="badge {{ $job_title->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $job_title->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                    @endcan --}}
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-dark"
                                                href="{{ route('job-titles.edit', $job_title) }}" title="تعديل">تعديل</a>

                                            <form action="{{ route('job-titles.destroy', $job_title) }}" title="حذف"
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
                url: '{{ route('job-titles.toggle-status', ':slug') }}'.replace(':slug', slug),
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
