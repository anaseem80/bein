@extends('front.layout.layout')
@section('title', 'تسجيل الدخول')
@section('content')

    <form method="POST" action="{{ route('login') }}" class="py-5 scrolling">
        @csrf
        <div class="container">
            <div class="form-group">
                <label for="username">البريد الإلكتروني <img
                        src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}" width="25px"
                        alt=""></label>
                <input type="email" id="username" value="{{ old('email') }}" name="email" class="form-control" required
                    placeholder="مثال">
            </div>
            <div class="form-group mt-4">
                <label for="password">كلمة السر <img
                        src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}" width="25px"
                        alt=""></label>
                <input type="password" id="password" name="password" required class="form-control" placeholder="*********">
            </div>
            <button class="main-button my-3 w-100">
                <p class="position-relative m-0">الدخول</p>
            </button>

            <div class="block mt-4 row">
                <div class="col-6 d-flex justify-content-end align-items-center">
                    <a class="btn btn-primary w-25" href="{{ route('login.facebook') }}"><i class="fa fa-facebook"></i></a>
                </div>
                <div class="col-6 d-flex justify-content-start align-items-center">
                    <a class="btn btn-danger w-25" href="{{ route('login.google') }}"><i class="fa fa-google"></i></a>
                </div>
            </div>

            <p>ليس لديك حساب؟ <a href="{{ route('register') }}" class="text-decoration-none">تسجيل حساب جديد</a></p>
            <p><a href="{{ route('password.request') }}" class="text-decoration-none">نسيت كلمة مرورك؟</a></p>
        </div>
    </form>
@endsection
