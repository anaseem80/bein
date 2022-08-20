@extends('front.layout.layout')
@section('title', isset($title) ? $title : '')
@section('content')
    <div class="py-5 scrolling">
        <div class="container">
            <h1 class="text-center text-danger">
                خطأ 404
                <br>
                الصفحة المطلوبة غير موجودة
                <br>
                 الذهاب إلى
                <a class="nav-link d-inline-block" href="{{ route('home') }}">
                    الصفحة الرئيسية
                </a>
            </h1>
        </div>
    </div>


    <div class="mb-4">
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>
@endsection
