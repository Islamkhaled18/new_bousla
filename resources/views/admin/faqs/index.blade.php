@extends('layouts.admin.app')
@section('title')
    الاسئلة الشائعة
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i>الاسئلة الشائعة</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>

                <li class="breadcrumb-item active"><a href="{{ route('faqs.index') }}" title="الاسئلة الشائعة">الاسئلة
                        الشائعة</a>
                </li>

            </ul>
        </div>
        <div>
            <a class="btn btn-primary btn-sm" href="{{ route('faqs.create') }}" title="انشاء سؤال شائع جديد">انشاء
                سؤال شائع جديد</a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>السؤال</th>
                                    <th>الجواب</th>
                                    <th>الحالة</th>
                                    <th>العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faqs as $faq)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $faq->question }}</td>
                                        <td>{{ $faq->answer }}</td>
                                        <td>
                                            {{-- @can('jobs.edit') --}}
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <input class="status-toggle" type="checkbox" id="status_{{ $faq->id }}"
                                                    data-uuid="{{ $faq->uuid }}" {{ $faq->is_active ? 'checked' : '' }}
                                                    style="width: 45px; height: 22px; cursor: pointer;">
                                                <span class="badge {{ $faq->is_active ? 'badge-success' : 'badge-danger' }}"
                                                    style="font-size: 13px; padding: 5px 10px;">
                                                    {{ $faq->is_active ? 'نشط' : 'غير نشط' }}
                                                </span>
                                            </div>
                                            {{-- @else
                                    <span class="badge {{ $job_title->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $job_title->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                    @endcan --}}
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-dark" href="{{ route('faqs.edit', $faq) }}"
                                                title="تعديل">تعديل</a>

                                            <a class="btn btn-sm btn-info" href="{{ route('faqs.show', $faq) }}"
                                                title="عرض">عرض</a>

                                            <form action="{{ route('faqs.destroy', $faq) }}" title="حذف" method="post"
                                                style="display: inline-block">
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
        $('.status-toggle').change(function() {
            let checkbox = $(this);
            let uuid = checkbox.data('uuid');
            let isActive = checkbox.is(':checked') ? 1 : 0;

            checkbox.prop('disabled', true);

            $.ajax({
                url: '{{ route('faqs.toggle-status', ':uuid') }}'.replace(':uuid', uuid),
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
