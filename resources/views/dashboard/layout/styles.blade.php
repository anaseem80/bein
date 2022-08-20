<link href="{{ asset('resources/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet"
    crossorigin="anonymous">
{{-- <link rel="stylesheet" href="{{asset('resources/assets/css/bootstrap5.min.css')}}" rel="stylesheet"> --}}
<link href="{{ asset('resources/assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
<!-- <link href="{{ asset('resources/assets/css/screen.css') }}" rel="stylesheet"> -->
<link href="{{ asset('resources/assets/css/custom.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
{{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-results__option--selected {
        display: none;
    }

    .bg-gradient-primary {
        background-color:{{App\Http\Controllers\SettingController::getSettingValue('sidebar_color')}};
        background-image: unset;
    }

</style>
