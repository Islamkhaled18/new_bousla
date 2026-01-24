@extends('layouts.admin.app')
@section('title')
    عرض سياسة الخصوصية
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> سياسة الخصوصية </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('privacy-policies.index') }}" title="سياسة الخصوصية">سياسة
                        الخصوصية
                    </a></li>

                <li class="breadcrumb-item active"><a href="{{ route('privacy-policies.edit', $privacy_policy) }}"
                        title="عرض  سياسة الخصوصية">عرض سياسة الخصوصية -
                        {{ $privacy_policy->text }}</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="tile">
                    <div class="tile-body">
                        <div class="col-lg-6">
                            <input name="id" value="{{ $privacy_policy->id }}" type="hidden">

                            <div class="form-group">
                                <label for="exampleInputEmail1">محتوى سياسة الخصوصية</label>
                                <textarea class="form-control" id="editor_one" name="text">{{ old('text', $privacy_policy->text) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">محتوى سياسة الخصوصية باللغة الإنجليزية</label>
                                <textarea class="form-control" id="editor_two" name="text_en">{{ old('text_en', $privacy_policy->text_en) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
@push('scripts')
    <script>
        ClassicEditor
            .create(document.querySelector('#editor_one'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor_two'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
