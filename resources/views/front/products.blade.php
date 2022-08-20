
@extends('front.layout.layout')
@section('title', isset($title) ? $title : '')
@section('content')
{{-- $device_id != null ? ['id' => $package->id, 'type' => $type, 'device_id' => $device_id] : ['id' => $package->id, 'type' => $type, 'device_id' => 0] --}}
<div class="py-5 scrolling">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 products flex-products d-flex flex-wrap">
                    @if (count($packages) == 0)
                        لا توجد باقات ليتم عرضها
                    @endif
                    @foreach ($packages as $package)
                        @if (isset($type))
                            <div class="mb-4 text-center product border p-5 position-relative border p-5 position-relative">
                                <a href="{{ route('product', isset($device_id)?($device_id != null ? ['id' => $package->id, 'type' => $type, 'device_id' => $device_id] : ['id' => $package->id, 'type' => $type, 'device_id' => 0]):(['id' => $package->id, 'type' => $type, 'device_id' => 0])) }}"
                                    class="text-decoration-none">
                                    @if ($package->is_offer)
                                        <span class="offer-circle">عرض</span>
                                    @endif
                                    <img src="{{ asset($package->image) }}" alt="" width="200px" height="200px">
                                    <p class="my-3"><a
                                            href="{{ route('product', isset($device_id)?($device_id != null ? ['id' => $package->id, 'type' => $type, 'device_id' => $device_id] : ['id' => $package->id, 'type' => $type, 'device_id' => 0]):(['id' => $package->id, 'type' => $type, 'device_id' => 0])) }}"
                                            class="main-color-yellow-hover text-dark text-decoration-none">
                                            {{ $package->name }}
                                        </a></p>

                                    <p>{{ $package->price_365 }}
                                        <x-currency />
                                    </p>
                                    <form method="GET"
                                        action="{{ route('completeOrder', isset($device_id)?($device_id != null ? ['id' => $package->id, 'type' => $type, 'device_id' => $device_id] : ['id' => $package->id, 'type' => $type, 'device_id' => 0]):(['id' => $package->id, 'type' => $type, 'device_id' => 0])) }}">
                                        <button class="add_to_cart main-button scrolling rounded-pill">
                                            <p class="position-relative m-0">اطلب الآن</p>
                                        </button>
                                    </form>

                                </a>
                            </div>
                        @else
                            @if ($package->type == 'both')
                                <div class="mb-4 text-center product border p-5 position-relative">
                                    <a href="{{ route('product', $device_id != null ? ['id' => $package->id, 'type' => 'new', 'device_id' => $device_id] : ['id' => $package->id, 'type' => 'new', 'device_id' => 0]) }}"
                                        class="text-decoration-none">
                                        @if ($package->is_offer)
                                            <span class="offer-circle">عرض</span>
                                        @endif
                                        <img src="{{ asset($package->image) }}" alt="" width="200px" height="200px">
                                        <p class="my-3"><a
                                                href="{{ route('product', $device_id != null ? ['id' => $package->id, 'type' => 'new', 'device_id' => $device_id] : ['id' => $package->id, 'type' => 'new', 'device_id' => 0]) }}"
                                                class="main-color-yellow-hover text-dark text-decoration-none">
                                                {{ $package->name }}
                                            </a></p>

                                        <p>{{ $package->price_365 }}
                                            <x-currency />
                                        </p>
                                        <form method="GET"
                                            action="{{ route('completeOrder', $device_id != null ? ['id' => $package->id, 'type' => 'new', 'device_id' => $device_id] : ['id' => $package->id, 'type' => 'new', 'device_id' => 0]) }}">
                                            <button class="add_to_cart main-button scrolling rounded-pill">
                                                <p class="position-relative m-0">
                                                    اطلب الآن
                                                    (اشتراك جديد)
                                                </p>
                                            </button>
                                        </form>

                                    </a>
                                </div>
                                <div class="mb-4 text-center product border p-5 position-relative">
                                    <a href="{{ route('product', ['id' => $package->id, 'type' => 'renew']) }}"
                                        class="text-decoration-none">
                                        @if ($package->is_offer)
                                            <span class="offer-circle">عرض</span>
                                        @endif
                                        <img src="{{ asset($package->image) }}" alt="" width="200px" height="200px">
                                        <p class="my-3"><a
                                                href="{{ route('product', ['id' => $package->id, 'type' => 'renew']) }}"
                                                class="main-color-yellow-hover text-dark text-decoration-none">
                                                {{ $package->name }}
                                            </a></p>

                                        <p>{{ $package->price_365 }}
                                            <x-currency />
                                        </p>
                                        <form method="GET"
                                            action="{{ route('completeOrder', ['id' => $package->id, 'type' => 'renew', 'device_id' => 0]) }}">
                                            <button class="add_to_cart main-button scrolling rounded-pill">
                                                <p class="position-relative m-0">
                                                    اطلب الآن
                                                    (تجديد الاشتراك)
                                                </p>
                                            </button>
                                        </form>

                                    </a>
                                </div>
                            @else
                                <div class="mb-4 text-center product border p-5 position-relative">
                                    <a href="{{ route('product', ['id' => $package->id, 'type' => $package->type, 'device_id' => 0]) }}"
                                        class="text-decoration-none">
                                        @if ($package->is_offer)
                                            <span class="offer-circle">عرض</span>
                                        @endif
                                        <img src="{{ asset($package->image) }}" alt="" width="200px" height="200px">
                                        <p class="my-3"><a
                                                href="{{ route('product', ['id' => $package->id, 'type' => $package->type, 'device_id' => 0]) }}"
                                                class="main-color-yellow-hover text-dark text-decoration-none">
                                                {{ $package->name }}
                                            </a></p>

                                        <p>{{ $package->price_365 }}
                                            <x-currency />
                                        </p>
                                        <form method="GET"
                                            action="{{ route('completeOrder', ['id' => $package->id, 'type' => $package->type, 'device_id' => 0]) }}">
                                            <button class="add_to_cart main-button scrolling rounded-pill">
                                                <p class="position-relative m-0">
                                                    اطلب الآن
                                                    ({{ $package->type == 'new' ? 'اشتراك جديد' : 'تجديد الاشتراك' }})
                                                </p>
                                            </button>
                                        </form>

                                    </a>
                                </div>
                            @endif
                        @endif
                    @endforeach

                </div>
                @include('front.layout.comments-latestarticles')

            </div>
        </div>
    </div>
@endsection
