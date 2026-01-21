@extends('layouts.admin.app')
@section('title')
    الشروط والحكام
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> الشروط والحكام </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item active"><a href="{{ route('terms.index') }}" title="الشروط والاحكام">الشروط
                        والاحكام</a></li>
            </ul>
        </div>
        <div>
            <a class="btn btn-primary btn-sm" href="{{ route('terms.create') }}" title="انشاء شروط واحكام جديده">انشاء
                شروط واحكام جديده</a>
            <a class="btn btn-warning btn-sm" href="{{ route('terms.acceptances') }}" title="الموافقون على الشروط والاحكام">
                الموافقون على الشروط والاحكام</a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>محتوى الشروط والاحكام</th>
                                    <th>محتوى الشروط والاحكام باللغه الانجليزيه</th>
                                    <th>الاصدار</th>
                                    <th>خاص بـ</th>
                                    <th>الحاله</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($terms as $term)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{!! Str::limit($term->name, 100) !!}</td>
                                        <td>{!! Str::limit($term->name_en, 100) !!}</td>
                                        <td>
                                            {{ match ($term->role) {
                                                'general' => 'عام',
                                                'patient' => 'مريض',
                                                'doctor' => 'دكتور',
                                                default => $term->role,
                                            } }}
                                        </td>
                                        <td>{{ $term->role }}</td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <input class="status-toggle" type="checkbox" id="status_{{ $term->id }}"
                                                    data-uuid="{{ $term->uuid }}" {{ $term->is_active ? 'checked' : '' }}
                                                    style="width: 45px; height: 22px; cursor: pointer;">
                                                <span
                                                    class="badge {{ $term->is_active ? 'badge-success' : 'badge-danger' }}"
                                                    style="font-size: 13px; padding: 5px 10px;">
                                                    {{ $term->is_active ? 'نشط' : 'غير نشط' }}
                                                </span>
                                            </div>

                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-dark" href="{{ route('terms.edit', $term) }}"
                                                title="تعديل">تعديل</a>

                                            <form action="{{ route('terms.destroy', $term) }}" method="post"
                                                style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger delete btn-sm">
                                                    <i class="fa fa-trash"></i> حذف
                                                </button>
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
                url: '{{ route('terms.toggle-status', ':uuid') }}'.replace(':uuid', uuid),
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
