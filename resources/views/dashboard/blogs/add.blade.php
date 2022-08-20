@extends('dashboard.layout.layout')
@section('title', $title ?? 'Dashboard')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('resources/assets/summernote/summernote.min.css') }}">
    <style>
        button.close {
            border: none !important;
            background-color: transparent !important;
            font-size: 30px !important;
            font-weight: bold !important;
        }

    </style>
@endsection
@section('content')
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">المقالات</a></li>
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
                <form id="form" action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
                @else
                    <form id="form" action="{{ route('blog.update', $blog) }}" method="post"
                        enctype="multipart/form-data">
                        @method('PUT')
            @endif
            @csrf
            <div class="row">
                <div class="col-12">
                    <x-upload-image :type="$action=='update'?1:0" :object="$action=='update'?$blog:null"
                        :delete-image="route('delete_blog_image')" />
                </div>
                <div class="form-group col-md-12">
                    <label>عنوان المقال</label>
                    <input type="text" class="form-control" autocomplete="off" name="name" id="name"
                        value="{{ $action == 'update' ? $blog->name : '' }}" required>
                </div>
                <div class="form-group col-md-12">
                    <label>الفئات</label>
                    <span id="add-category" style="cursor: pointer;" title="إضافة فئة جديدة"><i
                            class="fa fa-plus-circle text-primary"></i></span>
                    <?php
                    $ids = [];
                    if ($action == 'update') {
                        foreach ($blog->categories as $c) {
                            array_push($ids, $c->id);
                        }
                    }
                    ?>
                    <select class="form-control select2" name="categories[]" id="categories" multiple>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if (count($ids) > 0) @if (in_array($category->id, $ids)) selected @endif @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>محتوى المقال</label>
                    <textarea class="form-control summernote" required autocomplete="off" name="content" rows="20"
                        id="content">{{ $action == 'update' ? $blog->content : '' }}</textarea>
                </div>

            </div>
            <div class="form-group mt-3 text-end">
                <button class="btn btn-primary">حفظ</button>
                <input type="submit" class="btn btn-success" name="preview" value="حفظ ومعاينة">
            </div>
            </form>
            <hr>

        </div>
    </div>

@endsection
@section('page_js')
    <script>
        var store_category = "{{ route('category.store') }}";
    </script>
    <script src="{{ asset('resources/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/validate_blog.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/add_category.js') }}"></script>
    <script src="{{ asset('resources/assets/summernote/summernote.min.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/change_image.js') }}"></script>
    <script src="{{ asset('resources/assets/summernote/lang/summernote-ar-AR.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 350,
                lang: 'ar-AR'
            });
            $('.close').click(function() {
                $('.modal').modal('hide');
            })
        })
    </script>
@endsection
