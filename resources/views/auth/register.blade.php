@extends('front.layout.layout')
@section('title', 'تسجيل حساب جديد')
@section('content')
    <form method="POST" action="{{ route('register') }}" class="py-5 scrolling">
        @csrf
        <div class="container">
            <div class="form-group">
                <label for="fname">الاسم الاول <img src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}"
                        width="25px" alt=""></label>
                <input type="text" id="fname" class="form-control" placeholder="مثال" name="first_name" value="{{old('first_name')}}" required>
                @error('first_name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group mt-4">
                <label for="lname">الاسم الاخير <img src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}"
                        width="25px" alt=""></label>
                <input type="text" id="lname" class="form-control" placeholder="مثال" name="last_name" value="{{old('last_name')}}" required>
                @error('last_name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            {{-- <div class="form-group mt-4">
                <label for="username">اسم المستخدم<img
                        src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}" width="25px" alt=""></label>
                <input type="text" id="username" class="form-control" placeholder="مثال123">
            </div> --}}
            <div class="form-group mt-4">
                <label for="username">رقم التليفون<img
                        src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}" width="25px" alt=""></label>
                <input type="text" id="username" class="form-control numeric" name="mobile" value="{{old('mobile')}}" required placeholder="مثال123">
                @error('mobile')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group mt-4">
                <label for="email">البريد الإلكتروني<img
                        src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}" width="25px" alt=""></label>
                <input type="email" id="email" class="form-control" placeholder="مثال@مثال" name="email" value="{{old('email')}}" required>
                @error('email')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group mt-4">
                <label for="password">كلمة السر <img src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}"
                        width="25px" alt=""></label>
                <input type="password" id="password" class="form-control" placeholder="*********" name="password" required>
                @error('password')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group mt-4">
                <label for="password">تأكيد كلمة السر <img src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}"
                        width="25px" alt=""></label>
                <input type="password" id="password_confirmation" class="form-control" placeholder="*********" name="password_confirmation" required>
                @error('password_confirmation')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <button class="main-button my-3 w-100">
                <p class="position-relative m-0">الدخول</p>
            </button>
            <p>لديك حساب بالفعل؟ <a href="{{route('login')}}" class="text-decoration-none">تسجيل دخول</a></p>
        </div>
    </form>
@endsection
