@extends('front.layout.layout')
@section('title', isset($title) ? $title : '')
@section('content')
    <div class="py-5 scrolling mb-4">
        <div class="container mb-4">
            <h1 class="text-center text-danger mb-5">
               {{$exception->getMessage()}}
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
    </div>
@endsection
