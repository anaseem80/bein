@extends('front.layout.layout')
@section('title', isset($title) ? $title : '')
@section('content')
    <div class="py-5 scrolling">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 products flex-products d-flex flex-wrap">
                    @if (count($devices) == 0)
                        لا توجد أجهزة ليتم عرضها
                    @endif
                    @foreach ($devices as $device)
                            <div class="mb-4 text-center product border p-5 position-relative border p-5 position-relative">
                                <a href="{{ route('products', ['device_id' => $device->id, 'type' => 'new']) }}"
                                    class="text-decoration-none">
                                    <img src="{{ asset($device->image) }}" alt="" width="200px" height="200px">
                                    <p class="my-3"><a
                                            href="{{ route('products', ['device_id' => $device->id, 'type' => 'new']) }}"
                                            class="main-color-yellow-hover text-dark text-decoration-none">
                                            {{ $device->name }}
                                        </a></p>

                                    <p>{{ $device->price }}
                                        <x-currency />
                                    </p>
                              
                                        <button onclick="window.location.href='{{ route('products', ['device_id' => $device->id, 'type' => 'new']) }}'" class=" main-button scrolling rounded-pill">
                                            <p class="position-relative m-0">الباقات المتوفرة</p>
                                        </button>

                                </a>
                            </div>
                        
                    @endforeach

                </div>
                @include('front.layout.comments-latestarticles')

            </div>
        </div>
    </div>
@endsection
