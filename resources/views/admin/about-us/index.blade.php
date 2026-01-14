@extends('layouts.admin.app')
@section('title')
    عن المنظمة
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i>عن المنظمة</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item active"><a href="{{ route('about-us.index') }}" title="عن المنظمة">عن
                        المنظمة</a></li>
            </ul>
        </div>
        <div>
            <a class="btn btn-primary btn-sm" href="{{ route('about-us.create') }}" title="انشاء جديد">انشاء جديد</a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>عن المنظمة</th>
                                    <th>عن المنظمه باللغه الانجليزيه</th>
                                    <th>العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($about_us as $about_u)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>
                                        <td>{!! Str::limit($about_u->text, 100) !!}</td>
                                        <td>{!! Str::limit($about_u->text_en ?? '-', 100) !!}</td>
                                        <td>
                                            <a class="btn btn-sm btn-dark" href="{{ route('about-us.edit', $about_u) }}"
                                                title="تعديل">تعديل</a>

                                            <form action="{{ route('about-us.destroy', $about_u) }}" title="حذف"
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
    </script>
    <!-- Google analytics script-->
    <script type="text/javascript">
        if (document.location.hostname == 'pratikborsadiya.in') {
            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-72504830-1', 'auto');
            ga('send', 'pageview');
        }
    </script>
@endpush
