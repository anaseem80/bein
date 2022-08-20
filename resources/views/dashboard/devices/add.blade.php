@extends('dashboard.layout.layout')
@section('title', $title ?? 'Dashboard')
@section('content')
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('device.index') }}">الأجهزة</a></li>
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
                <form id="form" action="{{ route('device.store') }}" method="post" enctype="multipart/form-data">
                @else
                    <form id="form" action="{{ route('device.update', $device) }}" method="post"
                        enctype="multipart/form-data">
                        @method('PUT')
            @endif
            @csrf
            <div class="row">
                <div class="col-12">
                    <x-upload-image :type="$action == 'update' ? 1 : 0" :object="$action == 'update' ? $device : null" :delete-image="route('delete_device_image')" />
                </div>
                <div class="form-group col-lg-12">
                    <label>الموديل</label>
                    <input type="text" class="form-control" autocomplete="off" name="name" id="name"
                        value="{{ $action == 'update' ? $device->name : '' }}" required>
                </div>
                <div class="form-group col-lg-12">
                    <label>السعر</label>
                    <input type="text" class="form-control numeric" autocomplete="off" name="price" id="price"
                        value="{{ $action == 'update' ? $device->price : '' }}" required>
                </div>
                <div class="form-group mt-3 col-lg-12">
                    <label>الوصف</label>
                    <textarea class="form-control" autocomplete="off" name="description" id="description"
                        placeholder>{{ $action == 'update' ? $device->description : '' }}</textarea>
                </div>
                <h3 class="mt-3">مصاريف الشحن</h3>
                @foreach ($countries as $country)
                    <?php
                    if ($action == 'update') {
                        $shipping = '';
                        foreach ($device->countries as $c) {
                            if ($c->id == $country->id) {
                                $shipping = $c->pivot['shipping_price'];
                            }
                        }
                    }
                    ?>
                    <div class="form-group col-lg-7">
                        <label>{{ $country->name }}</label>
                        <input type="text" class="form-control numeric" autocomplete="off"
                            name="country_{{ $country->id }}" id="country_{{ $country->id }}"
                            value="{{ $action == 'update' ? $shipping : '' }}" required>
                    </div>
                @endforeach
            </div>
            <div class="form-group mt-3 text-end">
                <button class="btn btn-primary">حفظ</button>
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
