@extends('front.layout.layout')
@section('title', isset($title) ? $title : '')
@section('page_css')
    <style>
        .error {
            color: red;
        }
    </style>
@endsection
@section('content')
    <form id="form" action="{{ route('order.store') }}" method="POST">
        @csrf
        <input type="hidden" name="package_id" value="{{ $product->id }}">
        <input type="hidden" name="package_type" value="{{ $type }}">
        <input type="hidden" name="duration" value="{{ $duration }}">
        @isset($device)
            <input type="hidden" name="device_id" value="{{ $device->id }}">
        @endisset
        <input type="hidden" name="sub_total" value="{{ $product['price_' . $duration] }}">
        <div class="py-5 scrolling">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 product-main-container">
                        <div>
                            <h3>تفاصيل الفاتورة</h3>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="fname">الاسم الاول
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <input type="text" name="first_name" required id="fname" class="form-control"
                                        value="{{ $user?->first_name }}">
                                </div>
                                <div class="col-lg-6">
                                    <label for="lname">الاسم الاخير
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <input type="text" name="last_name" required id="lname" class="form-control"
                                        value="{{ $user?->last_name }}">
                                </div>
                            </div>
                            @if ($type == 'renew')
                                <div class="form-group mt-3">
                                    <label>beIN Card Number
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <input type="text" class="form-control" required name="bein_card_number" />
                                </div>
                            @endif
                            <div class="form-group mt-3">
                                <label for="select-state">الدولة / المنطقة
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <x-countries />
                            </div>
                            <div class="form-group mt-3">
                                <label for="street">العنوان كامل بالتفصيل
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <textarea type="text" name="address" id="street" required class="form-control"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="phonenubmer">الهاتف
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <div class="row">

                                    <div class="col-10">
                                        <input type="text" name="mobile" id="phonenubmer" class="form-control numeric"
                                            value="{{ $user?->mobile }}">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" name="mobile_key" id="phonekey" class="form-control numeric">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="email">البريد الالكتروني
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ $user?->email }}">
                            </div>
                        </div>
                        <div class="checkout-cart mt-5">
                            <h3 class="mb-3">طلبك</h3>
                            <table class="table border">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border">المنتج</th>
                                        <td scope="col">المجموع</td>
                                    </tr>

                                    <tr>
                                        <th scope="col" class="border">{{ $product->name }}</th>
                                        <th scope="col" class="border"><span
                                                id="price-duration">{{ $product['price_' . $duration] }}</span>
                                            <x-currency />
                                        </th>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="border">المدة</th>
                                        <th scope="col" class="border">
                                            <select id="choose_duration" class="form-control">
                                                @if ($product->price_90 != null && $product->price_90 != 0)
                                                    <option @if ($duration == '90') selected @endif
                                                        value="90">3
                                                        شهور</option>
                                                @endif
                                                @if ($product->price_180 != null && $product->price_180 != 0)
                                                    <option @if ($duration == '180') selected @endif
                                                        value="180">6
                                                        شهور</option>
                                                @endif
                                                @if ($product->price_365 != null && $product->price_365 != 0)
                                                    <option @if ($duration == '365') selected @endif
                                                        value="365">
                                                        سنة</option>
                                                @endif
                                            </select>
                                        </th>
                                    </tr>
                                    @if ($type == 'new')
                                        <tr>
                                            <th scope="col" class="border">الجهاز</th>
                                            <th scope="col" class="border">
                                                {{ $device->name }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th scope="col" class="border">سعر الجهاز</th>
                                            <th scope="col" class="border">
                                                <input type="hidden" name="device_price" value="{{ $device->price }}" />
                                                {{ $device->price }}
                                                <x-currency />
                                            </th>
                                        </tr>
                                        <tr>
                                            <th scope="col" class="border">الشحن</th>
                                            <th scope="col" class="border">
                                                <input type="hidden" name="shipping" />
                                                <span id="shipping"></span>
                                                <x-currency />
                                            </th>
                                        </tr>
                                    @endif
                                    @foreach ($taxes as $tax)
                                        <tr>
                                            <th scope="col" class="border">{{ $tax->key }}</th>
                                            <th scope="col" class="border taxes" data-value="{{ $tax->value }}"
                                                data-type="{{ $tax->description }}">{{ $tax->value }}
                                                {{ $tax->description == 'percent' ? '%' : '' }}</th>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th scope="col" class="border">الإجمالي</th>
                                        <th scope="col" class="border">
                                            <input type="hidden" name="taxes">
                                            <input type="hidden" name="total"
                                                data-total="{{ $type == 'renew' ? $product['price_' . $duration] : $product['price_' . $duration] + (isset($device) ? $device->price : 0) }}"
                                                value="{{ $type == 'renew' ? $product['price_' . $duration] : $product['price_' . $duration] + (isset($device) ? $device->price : 0) }}" />
                                            <span id="total">
                                                {{ $type == 'renew' ? $product['price_' . $duration] : $product['price_' . $duration] + (isset($device) ? $device->price : 0) }}
                                            </span>
                                            <x-currency />
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        {{-- <div class="payment p-3 bg-light border-rounded">
                            <div class="payment-way">
                                <input type="radio">
                                <span>tap</span>
                                <div>
                                    <!-- Here payment API -->
                                </div>
                            </div>
                        </div> --}}
                        <button class="main-button my-3 w-100 bg-warning" type="submit">
                            <p class="position-relative m-0">تأكيد الطلب</p>
                        </button>
                    </div>
                    @include('front.layout.comments-latestarticles')

                </div>
            </div>
        </div>
    </form>
@endsection
@section('page_js')
    <script>
        var product = @json($product);
        var countries = @json($countries);
        @if (isset($device))
            var theDevice = @json($device);
        @else
            var theDevice = null;
        @endif
        var type = "{{ $type }}";
    </script>
    <script src="{{ asset('resources/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/completeOrder.js?v=1') }}"></script>
    <script>
        $('.select2').select2()
    </script>
@endsection
