@extends('front.layout.layout')
@section('title', 'إعادة تعيين كلمة المرور')
@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="py-5 scrolling">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="container">
            <div class="form-group">
                <label for="username">   البريد الإلكتروني <img
                        src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}" width="25px" alt=""></label>
                <input type="email" id="username" class="form-control" placeholder="مثال" name="email" value="{{old('email',$request->email)}}" required>
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
                <p class="position-relative m-0">تغيير كلمة المرور</p>
            </button>
        </div>
    </form>
@endsection
