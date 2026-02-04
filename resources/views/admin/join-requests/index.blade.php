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

    <!-- Modal لأسباب الرفض -->
    <div class="modal fade" id="rejectionModal" tabindex="-1" role="dialog" aria-labelledby="rejectionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectionModalLabel">أسباب الرفض</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="rejectionForm">
                        <div class="form-group">
                            <label for="admin_notes">اكتب أسباب الرفض <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="admin_notes" name="admin_notes" rows="4" 
                                placeholder="يرجى كتابة أسباب رفض الطلب..." required></textarea>
                            <small class="form-text text-danger" id="admin_notes_error" style="display: none;"></small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-danger" id="confirmRejection">تأكيد الرفض</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script type="text/javascript">

    $('#sampleTable').DataTable();

    const toggleStatusRoute = "{{ route('join-requests.toggleStatus', ':id') }}";
    
    // متغيرات لحفظ الـ dropdown والـ id المؤقتين
    let currentDropdown = null;
    let currentJoinRequestId = null;

    $('.status-dropdown').on('change', function() {

        const id = $(this).data('id');
        const status = $(this).val();
        const dropdown = $(this);

        // لو اختار "مرفوض" نفتح الـ popup
        if (status === 'rejected') {
            currentDropdown = dropdown;
            currentJoinRequestId = id;
            
            // نمسح أي بيانات قديمة في الـ popup
            $('#admin_notes').val('');
            $('#admin_notes_error').hide();
            
            // نفتح الـ Modal
            $('#rejectionModal').modal('show');
            
            // نرجع الـ dropdown للقيمة السابقة مؤقتاً
            dropdown.val(dropdown.data('previous-value'));
            
            return; // نوقف التنفيذ هنا
        }

        // لو اختار "مقبول" أو "في الانتظار" ننفذ عادي
        updateStatus(id, status, dropdown, null);
    });

    // عند الضغط على زر تأكيد الرفض في الـ Modal
    $('#confirmRejection').on('click', function() {
        const adminNotes = $('#admin_notes').val().trim();
        
        // التحقق من أن الحقل مش فاضي
        if (adminNotes === '') {
            $('#admin_notes_error').text('يرجى كتابة أسباب الرفض').show();
            $('#admin_notes').focus();
            return;
        }
        
        if (adminNotes.length < 10) {
            $('#admin_notes_error').text('يجب أن تكون أسباب الرفض 10 أحرف على الأقل').show();
            $('#admin_notes').focus();
            return;
        }
        
        // إخفاء الـ Modal
        $('#rejectionModal').modal('hide');
        
        // تنفيذ عملية التحديث مع أسباب الرفض
        updateStatus(currentJoinRequestId, 'rejected', currentDropdown, adminNotes);
    });

    // عند إلغاء الـ Modal، نرجع الـ dropdown للقيمة السابقة
    $('#rejectionModal').on('hidden.bs.modal', function () {
        if (currentDropdown) {
            currentDropdown.val(currentDropdown.data('previous-value'));
        }
        currentDropdown = null;
        currentJoinRequestId = null;
    });

    // دالة تحديث الحالة
    function updateStatus(id, status, dropdown, adminNotes) {
        const data = {
            status: status,
            _token: '{{ csrf_token() }}'
        };
        
        // لو في admin_notes نضيفها للـ request
        if (adminNotes) {
            data.admin_notes = adminNotes;
        }

        $.ajax({
            url: toggleStatusRoute.replace(':id', id),
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.success) {

                    // نعرض رسالة نجاح (إذا كنت بتستخدم toastr)
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message);
                    }

                    // نحدث القيمة السابقة
                    dropdown.data('previous-value', status);
                    dropdown.val(status);

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
                    if (typeof toastr !== 'undefined') {
                        toastr.error('حدث خطأ أثناء تحديث الحالة');
                    }
                    dropdown.val(dropdown.data('previous-value'));
                }
            },
            error: function(xhr) {
                let errorMessage = 'حدث خطأ أثناء تحديث الحالة';
                
                // نعرض رسالة الخطأ من السيرفر لو موجودة
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                // نعرض أخطاء الـ validation لو موجودة
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    if (errors.admin_notes) {
                        errorMessage = errors.admin_notes[0];
                    }
                }
                
                if (typeof toastr !== 'undefined') {
                    toastr.error(errorMessage);
                } else {
                    alert(errorMessage);
                }
                
                dropdown.val(dropdown.data('previous-value'));
            }
        });
    }

    // Store initial values
    $('.status-dropdown').each(function() {
        $(this).data('previous-value', $(this).val());
    });

</script>
@endpush