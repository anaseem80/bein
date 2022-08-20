@extends('dashboard.layout.layout')
@section('title', $title ?? 'Dashboard')
@section('content')
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('offers.index') }}">العروض</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-12">
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ $title }}
                    </h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($action == 'add')
                <form id="form" action="{{ route('offers.store') }}" method="post" enctype="multipart/form-data">
                @else
                    <form id="form" action="{{ route('offers.update', $offer) }}" method="post"
                        enctype="multipart/form-data">
                        @method('PUT')
            @endif
            @csrf
            <div class="row">
                <div class="col-8">
                    <label>اختر الباقة</label>
                    <select class="form-control select2" id="package_id">
                        <option value="" selected disabled>اختر باقة</option>
                        @foreach ($packages as $package)
                            <option value="{{ $package->id }}">{{ $package->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-8">
                    <label>السعر</label>
                    <input class="form-control numeric" id="newPrice" />
                </div>
                <div class="col-8">
                    <label>المدة</label>
                    <input class="form-control numeric" id="newDuration" />
                </div>
                <div class="col-8">
                    <label>يبدأ في</label>
                    <input class="form-control" id="newFrom" type="date" />
                </div>
                <div class="col-8">
                    <label>ينتهي في</label>
                    <input class="form-control" id="newTo" type="date" />
                </div>


                <div class="form-group mt-3 text-end">
                    <button class="btn btn-primary">حفظ</button>
                </div>
            </div>
            </form>
            <hr>

        </div>
    </div>

@endsection
@section('page_js')
    <script src="{{ asset('resources/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/validate_device.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/change_image.js') }}"></script>
@endsection
