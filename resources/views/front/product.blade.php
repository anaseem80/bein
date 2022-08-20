@extends('front.layout.layout')
@section('title', isset($title) ? $title : '')
@section('content')
@section('variables')
    <?php
    if (App\Http\Controllers\SettingController::getSettingValue('packages_cover') != null) {
        $cover = asset(App\Http\Controllers\SettingController::getSettingValue('packages_cover'));
    }
    if ($package->cover) {
        $cover = asset($package->cover);
    }
    ?>
@endsection
<div class="py-5 scrolling">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 product-main-container">
                <h3>
                    <!-- @if ($package->is_offer)
<div class="text-center"><span class="bg-warning position-absolute text-center">عرض</span>
                        </div><br>
@endif -->
                    {{ $package->name }}
                </h3>
                <h3 class="d-flex justify-content-end">
                    {{-- @if ($package->type == 'both')
                        @if ($type == 'new')
                            <a class="text-success text-decoration-none"
                                href="{{ route('product', ['id' => $package->id, 'type' => 'renew']) }}">تجديد
                                الإشتراك</a>
                        @else
                            <a class="text-success text-decoration-none"
                                href="{{ route('product', ['id' => $package->id, 'type' => 'new']) }}">إشتراك جديد</a>
                        @endif
                    @endif --}}
                </h3>
                <div class="product-detials mb-5">
                    <img src="{{ asset($package->image) }}" alt="" width="300px" height="300px">
                    <div>
                        <div>
                            <label>سعر الباقة</label>
                            <h4 class="text-success"><span id="product_price"></span>
                                <x-currency />
                            </h4>
                            <label class="mt-3">مدة الإشتراك</label>
                            <select class="form-control" style="width: 150px;" id="product_duration">
                                @if ($package->price_90 != null && $package->price_90 != 0)
                                    <option value="90"> 3 شهور</option>
                                @endif
                                @if ($package->price_180 != null && $package->price_180 != 0)
                                    <option value="180"> 6 شهور</option>
                                @endif
                                @if ($package->price_365 != null && $package->price_365 != 0)
                                    <option value="365" selected> سنة</option>
                                @endif
                            </select>

                            <button
                                data-url="{{ route('completeOrder',  ['id' => $package->id, 'type' => $type, 'device_id' => isset($attachedDevice)?$attachedDevice->id:0] ) }}"
                                class="//add_to_cart completeOrder main-button my-3 w-100">
                                <p class="position-relative m-0">اطلب الآن</p>
                            </button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="product-description" style="margin: 100px 0;">
                    <h2>الوصف<img src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}" width="25px"
                            alt=""></h2>
                    <p>
                        {!! $package->description !!}
                    </p>
                </div>
                <hr>
                @if ($type == 'new')
                    <div class="product-description" style="margin: 100px 0;" id="device">
                        <h2> الجهاز المرفق<img src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}"
                                width="25px" alt=""></h2>
                        <div class="d-flex justify-content-center align-items-center">
                            @if ($attachedDevice->image != null)
                                <img src="{{ asset($attachedDevice->image) }}"
                                    style="max-height:200px;max-width:200px;" />
                            @endif
                        </div>
                        <p>
                        <h4><span class="text-primary"> موديل الجهاز : </span>{{ $attachedDevice->name }}</h4>
                        </p>
                        <p>
                        <h4><span class="text-primary"> سعر الجهاز : </span>{{ $attachedDevice->price }}
                            <x-currency />
                        </h4>
                        </p>
                        <p>
                        <h4><span class="text-primary"> وصف الجهاز : </span>{{ $attachedDevice->description }}
                        </h4>
                        </p>
                    </div>
                    <hr>
                @endif
                @if (count($package->channelImages) > 0)
                    <div class="product-description" style="margin: 100px 0;" id="device">
                        <h2> القنوات<img src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}"
                                width="25px" alt=""></h2>
                        <div class="w-100">
                            @foreach ($package->channelImages as $img)
                                <div class="d-inline-block ms-2 mt-2">
                                    <img src="{{ asset($img->image) }}" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                @endif
                <div class="product-comment" style="margin: 100px 0;">
                    <x-comments :item="$package" type="packages" />
                </div>
                <hr>
                <div class="related-products mt-5">
                    <h1>منتجات ذات صلة</h1>
                    <div class="products row mt-3">
                        @foreach ($relatedPackages as $r_package)
                            <div class="col-lg-3 mb-4 text-center product">
                                <a href="{{ route('product', ['id' => $r_package->id, 'type' => $r_package->type == 'both' ? 'new' : $r_package->type]) }}"
                                    class="text-decoration-none">
                                    <img src="{{ asset($r_package->image) }}" alt=""
                                        style="width:100% !important;height:auto !important">
                                    <p class="my-3">
                                        <a href="{{ route('product', ['id' => $r_package->id, 'type' => $r_package->type == 'both' ? 'new' : $r_package->type]) }}"
                                            class="main-color-yellow-hover text-dark text-decoration-none">
                                            {{ $r_package->name }}
                                        </a>
                                    </p>
                                    <p>{{ $r_package->price_365 ? $r_package->price_365 : ($r_package->price_180 ? $r_package->price_180 : $r_package->price_90) }}
                                        <x-currency />
                                    </p>
                                    {{-- <button data-id="{{ $r_package->id }}"
                                        class="add_to_cart main-button scrolling rounded-pill">
                                        <p class="position-relative m-0">إضافة الي السلة</p>
                                    </button> --}}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @include('front.layout.comments-latestarticles')

        </div>
    </div>
</div>
@endsection
@section('page_js')
<script>
    var product = @json($package);
</script>
<script src="{{ asset('resources/assets/js/content/product.js') }}"></script>
@if (!isset($preview))
    <script src="{{ asset('resources/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/add_comment.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/remove.js') }}"></script>
@endif
@endsection
