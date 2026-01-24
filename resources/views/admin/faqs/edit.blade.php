@extends('layouts.admin.app')
@section('title')
    تعديل سؤال شائع - {{ $faq->question }}
@endsection
@section('content')
    <main class="app sidebar-mini rtl">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-th-list"></i> الاسئلة الشائعة</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i><a href="{{ route('dashboard') }}"></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('faqs.index') }}" title="الاسئلة">الاسئلة</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('faqs.edit', $faq) }}" title="تعديل على السؤال">تعديل
                        على السؤال -
                        {{ $faq->question }}</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="tile">
                    <div class="tile-body">
                        <div class="col-lg-6">
                            <form action="{{ route('faqs.update', $faq) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <input name="id" value="{{ $faq->id }}" type="hidden">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">السؤال</label>
                                    <input class="form-control" id="exampleInputEmail1" name="question"
                                        value="{{ $faq->question }}" type="text" placeholder="اكتب السؤال">
                                    @error('question')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">الجواب</label>
                                    <textarea class="form-control" id="exampleInputEmail1" name="answer" rows="4" placeholder="اكتب الجواب">{{ $faq->answer }}</textarea>
                                    @error('answer')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="tile-footer">
                                    <button class="btn btn-primary" type="submit">تعديل</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
