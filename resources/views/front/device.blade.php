@extends('front.layout.layout')
@section('title', isset($title) ? $title : '')
@section('content')
    <div class="py-5 scrolling">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 product-main-container">

                    <div class="product-description" style="margin: 100px 0;" id="device">
                        <h2> جهاز {{ $device->name }} <img
                                src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}" width="25px"
                                alt=""></h2>
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset($device->image) }}" style="max-height:200px;max-width:200px;" />
                        </div>
                        <p>
                            @if ($price_device > 0)
                                <h4><span class="text-primary"> سعر الجهاز : </span>{{ $price_device }}
                                    <x-currency />
                                </h4>
                            @endif
                        </p>
                        <p>
                        <h4><span class="text-primary"> وصف الجهاز : </span>{{ $device->description }}
                        </h4>
                        </p>
                    </div>
                    <hr>

                </div>
                @include('front.layout.comments-latestarticles')

            </div>
        </div>
    </div>
@endsection
