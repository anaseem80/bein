<?php
use App\Http\Controllers\SettingController;
$currency=SettingController::getSettingValue('currency');
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon"
        href="{{ SettingController::getSettingValue('logo') ? asset(SettingController::getSettingValue('logo')) : '' }}"
        type="image/*" sizes="20x20">
    <title>@yield('title')</title>

    @include('dashboard.layout.styles')
    @yield('page_css')
    <script>
        var success = null;
        var dashboard_site = "{{ route('dashboard') }}";
        var home_site = "{{ route('home') }}";
        var img = "{{ asset('resources/assets/img/upload-image.png') }}";
        var currency="{{$currency}}"
    </script>
</head>

<body id="page-top" lang="ar" dir="rtl">


    <div id="wrapper">

        <form method="post" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" id="logout"></button>
        </form>



        <!-- Sidebar -->
        @include('dashboard.layout.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('dashboard.layout.navbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @if ($message = Session::get('alert'))
                        <div class="alert alert-danger w-100 text-center ">
                            {{ $message }}
                            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger ">
                            {{ $message }}
                            <button type="button" class="close white-text text-center" data-dismiss="alert"
                                aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger text-center">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br />
                    @endif
                </div>
                <div id="toast-container"></div>
                <div class="container-fluid">
                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('dashboard.layout.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary logout" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>


    @include('dashboard.layout.scripts')
    <script>
        @if (Session::get('success'))
            success="{{ Session::get('success') }}";
        @endif
    </script>
    @yield('page_js')

</body>

</html>
