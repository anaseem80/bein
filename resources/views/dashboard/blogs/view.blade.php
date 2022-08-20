@extends('dashboard.layout.layout')
@section('title', $title ?? 'Dashboard')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('resources/assets/summernote/summernote.min.css') }}">
@endsection
@section('content')
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">المقالات</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }} <a title="تعديل المقال" href="{{route('blog.edit',$blog)}}"><i class="fa fa-edit"></i></a></li>
            </ol>
        </nav>
    </div>
<div>
    <h2>{{$blog->name}}</h2>
    <div>{!! $blog->content !!}</div>
</div>

@endsection
@section('page_js')
<script>
    var store_category="{{route('category.store')}}";
</script>
    <script src="{{ asset('resources/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/validate_blog.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/add_category.js') }}"></script>
    <script src="{{ asset('resources/assets/summernote/summernote.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 350,
            });
        })
    </script>
@endsection
