@extends('front.layout.layout')
@section('title', 'إعادة تعيين كلمة المرور')
@section('content')
    <form method="POST" action="{{ route('password.email') }}" class="py-5 scrolling">
        @csrf

        <div class="container">
            <div class="form-group">
                <label for="username">   البريد الإلكتروني <img
                        src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}" width="25px" alt=""></label>
                <input type="email" id="username" class="form-control" placeholder="مثال" name="email" value="{{old('email')}}" required>
            </div>
            <button class="main-button my-3 w-100">
                <p class="position-relative m-0">إرسال رابط تغيير كلمة المرور</p>
            </button>
        </div>
    </form>
@endsection
