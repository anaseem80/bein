@extends('dashboard.layout.layout')
@section('title', $title ?? 'Dashboard')
@section('content')
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('category.index') }}">الفئات</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-12">
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ $title }}
                    </h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($action == 'add')
                <form id="form" action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                @else
                    <form id="form" action="{{ route('category.update', $category) }}" method="post"
                        enctype="multipart/form-data">
                        @method('PUT')
            @endif
            @csrf
            <div class="row">
                <div class="form-group col-lg-12">
                    <label>الاسم</label>
                    <input type="text" class="form-control" autocomplete="off" name="name" id="name"
                        value="{{ $action == 'update' ? $category->name : '' }}" required>
                </div>


            </div>
            <div class="form-group mt-3 text-end">
                <button class="btn btn-primary">حفظ</button>
            </div>
            </form>
            <hr>

        </div>
    </div>

@endsection
@section('page_js')
    <script src="{{ asset('resources/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/validate_category.js') }}"></script>
@endsection
