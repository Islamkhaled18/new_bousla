@extends('layouts.admin.app')
@section('title')
    طلبات الانضمام
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i>طلبات الانضمام </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>

                <li class="breadcrumb-item active"><a href="{{ route('join-requests.index') }}" title="طلبات الانضمام">طلبات
                        الانضمام</a>
                </li>

            </ul>
        </div>
        <div>
            <a class="btn btn-primary btn-sm" href="{{ route('join-requests.create') }}" title="انشاء طلب انضمام جديد">انشاء
                طلب انضمام
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
                                    <th>الاسم بالكامل</th>
                                    <th>رقم الهاتف</th>
                                    <th>العنوان</th>
                                    <th>الحالة</th>
                                    <th>العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($join_requests as $join_request)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $join_request->full_name }}</td>
                                        <td>{{ $join_request->phone ?? '-' }}</td>
                                        <td>{{ $join_request->address ?? '-' }}</td>
                                        <td>
                                          
                                                <select class="form-control status-dropdown" data-id="{{ $join_request->id }}"
                                                    style="width: 120px;">
                                                    <option value="pending"
                                                        {{ ($join_request->status ?? 'pending') == 'pending' ? 'selected' : '' }}>
                                                        في الانتظار
                                                    </option>
                                                    <option value="accepted"
                                                        {{ ($join_request->status ?? '') == 'accepted' ? 'selected' : '' }}>
                                                        مقبول
                                                    </option>
                                                    <option value="rejected"
                                                        {{ ($join_request->status ?? '') == 'rejected' ? 'selected' : '' }}>
                                                        مرفوض
                                                    </option>
                                                </select>
                                            {{-- @else
                                                <span
                                                    class="badge badge-{{ ($join_request->status ?? 'pending') == 'accepted'
                                                        ? 'success'
                                                        : (($join_request->status ?? 'pending') == 'rejected'
                                                            ? 'danger'
                                                            : 'warning') }}">
                                                    {{ ($join_request->status ?? 'pending') == 'accepted'
                                                        ? 'مقبول'
                                                        : (($join_request->status ?? 'pending') == 'rejected'
                                                            ? 'مرفوض'
                                                            : 'في الانتظار') }}
                                                </span>
                                            @endcan --}}
                                        </td>

                                        <td>
                                            <a class="btn btn-sm btn-dark"
                                                href="{{ route('join-requests.edit', $join_request) }}"
                                                title="تعديل">تعديل</a>

                                            <a class="btn btn-sm btn-info"
                                                href="{{ route('join-requests.show', $join_request) }}"
                                                title="عرض">عرض</a>

                                            <form action="{{ route('join-requests.destroy', $join_request) }}"
                                                title="حذف" method="post" style="display: inline-block">
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

    const toggleStatusRoute = "{{ route('join-requests.toggleStatus', ':id') }}";

    $('.status-dropdown').on('change', function() {

        const id = $(this).data('id');
        const status = $(this).val();
        const dropdown = $(this);

        $.ajax({
            url: toggleStatusRoute.replace(':id', id),
            type: 'POST',
            data: {
                status: status,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {

                    // toastr.success(response.message);

                    if (status === 'accepted' || status === 'rejected') {
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    } else {
                        const row = dropdown.closest('tr');
                        row.removeClass('table-warning table-success table-danger');
                        row.addClass('table-warning');
                    }

                } else {
                    console.log(response);
                }
            },
            error: function(xhr) {
                toastr.error('حدث خطأ أثناء تحديث الحالة');
                dropdown.val(dropdown.data('previous-value'));
            }
        });

        dropdown.data('previous-value', status);
    });

    // Store initial values
    $('.status-dropdown').each(function() {
        $(this).data('previous-value', $(this).val());
    });

</script>
@endpush
