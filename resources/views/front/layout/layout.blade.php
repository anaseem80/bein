<?php
use App\Http\Controllers\SettingController;
$currency = SettingController::getSettingValue('currency');
?>
<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon"
        href="{{ SettingController::getSettingValue('logo') ? asset(SettingController::getSettingValue('logo')) : '' }}"
        type="image/*" sizes="20x20">
    <title>@yield('title')</title>
    @include('front.layout.styles')
    @yield('page_css')
    @yield('variables')
    <?php
    if (!isset($page)) {
        $page = '';
    }
    if (!isset($is_preview)) {
        $is_preview = false;
    }
    $has_cover=true;
    if (!isset($cover)) {
        $has_cover=false;
        $cover = asset('resources/front/images/visuel.jpg');
    }
    ?>
    <script>
        var success = null;
        var csrf_token = "{{ csrf_token() }}";
        var home_site = "{{ route('home') }}";
        var add_to_cart = "{{ route('add_to_cart') }}";
        var cart_counter = "{{ route('get_cart_counter') }}";
        var currency = "{{ $currency }}"
    </script>
</head>

<body>
    <form method="post" action="{{ route('logout') }}" class="logout-form">
        @csrf
        <button type="submit" id="logout"></button>
    </form>
    @include('front.layout.navbar', ['page' => $page, 'is_preview' => $is_preview])
    @if ($page != 'index')
        <div class="main-banner scrolling d-flex flex-column align-items-center justify-content-center"
            style="background-image: url({{ $cover }});@if($has_cover) background-attachment:unset !important @endif">
            <h1 class="text-light text-center">@yield('title')</h1>
        </div>
    @endif
    <div id="toast-container"></div>
    @yield('content')

    @if (!Route::currentRouteNamed('completeOrder'))
        {{-- <div id="cart-btn"
            class="button-bottom-fixed position-fixed px-4 py-3 rounded-pill shadow-lg bg-success text-light">
            <span id="cart-counter" class="hidden">3</span>
            <i class="fas fa-shopping-basket fs-5 ms-1"></i>
            <span class="fs-5">السلة</span>
        </div> --}}
        @if (SettingController::getSettingValue('telephone'))
            <div class="btn-group dropup">
                <div id="cart-btn" data-bs-toggle="dropdown" aria-expanded="false"
                    class="button-bottom-fixed position-fixed rounded-circle shadow-lg bg-success text-light d-flex justify-content-center align-items-center"
                    style="height:80px;width:80px;">
                    <i class="fab fa-whatsapp fs-1"></i>
                </div>
                <div class="dropdown-menu alert-success border-success p-3" style="width:300px;height:300px">
                    <form method="get" target="_blank"
                        action="https://wa.me/{{ SettingController::getSettingValue('telephone') }}">
                        <textarea name="text" placeholder="اكتب رسالتك..." class="form-control" rows="8" style="resize: none;"></textarea>
                        <button type="submit"
                            class="btn btn-success mt-3 rounded-circle d-flex justify-content-center align-items-center"
                            title="ارسال" style="height:50px;width:50px;"><i class="material-icons">&#xe163;</i></button>
                    </form>
                </div>
            </div>
        @endif
    @endif

    @include('front.layout.footer')
    @include('front.layout.scripts')
    @yield('page_js')
    <script>
        @if (Session::get('success'))
            success = "{{ Session::get('success') }}";
        @endif
    </script>
</body>

</html>
