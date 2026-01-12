@extends('layouts.admin.app')
@section('title')
    صور الاعلانات
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> صور الاعلانات </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item active"><a href="{{ route('ads.index') }}" title="صور الاعلانات">صور
                        الاعلانات</a></li>
            </ul>
        </div>
        <div>
            <a class="btn btn-primary btn-sm" href="{{ route('ads.create') }}" title="انشاء صورة اعلان جديده">انشاء
                صورة
                اعلان جديده</a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم الاعلان</th>
                                    <th>اسم الاعلان باللغه الانجليزيه</th>
                                    <th>صورة الاعلان</th>
                                    <th>تاريخ البداية</th>
                                    <th>تاريخ النهاية</th>
                                    <th>الحاله</th>
                                    <th>العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ads as $ad)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ad->name }}</td>
                                        <td>{{ $ad->name_en ?? '-' }}</td>

                                        <td><img src="{{ $ad->image_url }}" title="{{ $ad->name }}"
                                                alt="{{ $ad->name }}" width="60" height="60">
                                        </td>
                                        <td>{{ $ad->start_date }}</td>
                                        <td>{{ $ad->end_date }}</td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <input class="status-toggle" type="checkbox"
                                                    id="status_{{ $ad->id }}" data-slug="{{ $ad->slug }}"
                                                    {{ $ad->is_active ? 'checked' : '' }}
                                                    style="width: 45px; height: 22px; cursor: pointer;">
                                                <span class="badge {{ $ad->is_active ? 'badge-success' : 'badge-danger' }}"
                                                    style="font-size: 13px; padding: 5px 10px;">
                                                    {{ $ad->is_active ? 'نشط' : 'غير نشط' }}
                                                </span>
                                            </div>

                                        </td>

                                        <td>
                                            <a class="btn btn-sm btn-dark" title="تعديل"
                                                href="{{ route('ads.edit', $ad) }}">تعديل</a>

                                            <form action="{{ route('ads.destroy', $ad) }}" method="post"
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
                url: '{{ route('ads.toggle-status', ':slug') }}'.replace(':slug', slug),
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
