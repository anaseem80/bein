@extends('front.layout.layout')
@section('title', isset($title) ? $title : '')
@section('variables')
    @php($page = 'index')
@endsection
@section('content')
    <div class="swiper mySwiper scrolling carsoual">
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
                <div class="swiper-slide h-auto" style="background-image: url({{ asset($slider->image) }})">
                    <div class="overlay position-absolute w-100 h-100"></div>
                    <h1 class="text-light my-3">
                        {!! $slider->title !!}
                    </h1>
                    <div class="row">
                        @if ($slider->new)
                            <div class="col-6">
                                <a href="//{{ $slider->new }}" target="_blank"><button class="main-button my-3">
                                        <p class="position-relative m-0">اشتراك جديد </p>
                                    </button></a>
                            </div>
                        @endif
                        @if ($slider->renew)
                            <div class="col-6">
                                <a href="//{{ $slider->renew }}" target="_blank"><button class="main-button my-3">
                                        <p class="position-relative m-0">تجديد الاشتراك</p>
                                    </button></a>
                            </div>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>


    <div class="main-background-color mt-3 scrolling ad-container"
        style="background-image: url({{ asset('resources/front/images/visuel.jpg') }});">
        <div class="container">
            <div class="world-cup mt-5">
                <div class="row px-5 py-5">
                    <div class="col-lg-6 align-items-center">
                        <h1 class="m-0 text-light">تجديد بي ان سبورت اون لاين</h1>
                    </div>
                    <div class="col-lg-6 d-flex flex-wrap flex-wrap text-start">
                        <a href="{{ route('products', 'renew') }}"><button class="main-button bg-dark ms-1">
                                <p class="position-relative m-0">معرفة المزيد</p>
                            </button></a>
                        @if ($worldCup)
                            <a href="{{ route('product', ['id' => $worldCup->value, 'type' => 'renew']) }}"><button
                                    class="main-button bg-success">
                                    <p class="text-light position-relative m-0"> {{ $worldCup->name }} </p>
                                </button></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="company-information mt-3 scrolling text-center"
        style="background-image: url({{asset('resources/front/images/background-feature.png')}});">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="rounded p-5">
                        <p class="d-inline-block bg-light text-light main-yellow-hover m-0 p-4 fs-3 rounded-circle shadow"
                            style="width: 90px;"><i class="fa fa-key main-color"></i></p>
                        <h3 class="mt-5 text-light"><a href="#"
                                class="main-color-yellow-hover text-light text-decoration-none">ما يميز قناة بي ان عن
                                غيرها</a></h3>
                        <p class="text-light">قناة بي ان سبورت الكويت ليست قناة حديثة في المجال، ولكنها قناة لها
                            تاريخ...</p>
                        <a href="#"><button class="main-button my-3">
                                <p class="position-relative m-0">إقرء المزيد</p>
                            </button></a>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="rounded p-5">
                        <p class="d-inline-block bg-light text-light main-yellow-hover m-0 p-4 fs-3 rounded-circle shadow"
                            style="width: 90px;"><i class="fa fa-key main-color"></i></p>
                        <h3 class="mt-5 text-light"><a href="#"
                                class="main-color-yellow-hover text-light text-decoration-none">ما يميز قناة بي ان عن
                                غيرها</a></h3>
                        <p class="text-light">قناة بي ان سبورت الكويت ليست قناة حديثة في المجال، ولكنها قناة لها
                            تاريخ...</p>
                        <a href="#"><button class="main-button my-3">
                                <p class="position-relative m-0">إقرء المزيد</p>
                            </button></a>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="rounded p-5">
                        <p class="d-inline-block bg-light text-light main-yellow-hover m-0 p-4 fs-3 rounded-circle shadow"
                            style="width: 90px;"><i class="fa fa-key main-color"></i></p>
                        <h3 class="mt-5 text-light"><a href="#"
                                class="main-color-yellow-hover text-light text-decoration-none">ما يميز قناة بي ان عن
                                غيرها</a></h3>
                        <p class="text-light">قناة بي ان سبورت الكويت ليست قناة حديثة في المجال، ولكنها قناة لها
                            تاريخ...</p>
                        <a href="#"><button class="main-button my-3">
                                <p class="position-relative m-0">إقرء المزيد</p>
                            </button></a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="bg-dark py-3">
        <div class="container">
            <div class="text-center my-5">
                <h1 class="text-light">شركة بى إن سبورت الرياضية</h1>
                <p class="col-lg-6 m-auto mt-3 text-light">لكل عملاء شركة بي ان سبورت الكويت ، الذين ينتظرون منها الكثير
                    والكثير، وذلك على مدار سنوات عدة، تستطيع الأن بكل سهولة التواصل مع الشركة ، وذلك عن طريق رقم بي ان سبورت
                    الموحد 99827209 ، من أجل طلب الخدمات الخاصة بالشركة، ومعرفة المزيد عنها بشكل دوري ليس هذا فقط ، يمكنك
                    أيضا عن طريق هذا الرقم 99827209 ، يمكنك أن تعمل على اختيار الباقات التي تناسبك، والإستعلام عن أسعار
                    الباقات، وغيرها من الخدمات التي نعلن عنها من خلال موقعنا</p>
            </div>
        </div>
    </div> --}}
    <div class="py-5">
        <div class="container scrolling mb-5">
            <h1 class="text-center">اهم الباقات المتوفرة</h1>
            <p class="col-lg-6 text-center m-auto mt-3 text-dark">

                {!! $mainPackagesParagraph['value'] !!}

            </p>
            <div class="packages-index row">
                @foreach ($impPackages as $package)
                    <div class="col-lg-4 my-3">
                        <div class="text-center border py-5 px-3">
                            <img src="{{ asset($package->image) }}" width="230px" height="230px" alt="">
                            <h5 class="my-3"><a href="{{ route('product', ['id' => $package->key, 'type' => 'new']) }}"
                                    class="main-color-yellow-hover text-dark text-decoration-none">
                                    {{ $package->name }}
                                </a>
                            </h5>
                            <p>المعلومات اللازمه هنا</p>
                            <p>{{ $package->price_365 }}
                                <x-currency />
                            </p>
                            {{-- <button type="button" data-id="{{ $package->key }}"
                                        class="add_to_cart main-button rounded-pill shadow d-block m-auto">
                                        <p class="position-relative m-0">إضافة الي السلة</p>
                                    </button> --}}
                            <div class="row">
                                <div @class([
                                    'col-6' => $package->type == 'both',
                                    'hidden' => $package->type == 'renew',
                                ])>
                                    <a class="main-button rounded-pill shadow d-block m-auto text-decoration-none"
                                        href="{{ route('product', ['id' => $package->key, 'type' => 'new']) }}">
                                        <p class="position-relative m-0">إشتراك جديد</p>
                                    </a>
                                </div>
                                <div @class([
                                    'col-6' => $package->type == 'both',
                                    'hidden' => $package->type == 'new',
                                ])>
                                    <a class="main-button rounded-pill shadow d-block m-auto text-decoration-none"
                                        href="{{ route('product', ['id' => $package->key, 'type' => 'renew']) }}">
                                        <p class="position-relative m-0">تجديد إشتراك</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="available-devices-content scrolling mt-5 mb-5">
        <div class="container">
            <div class="text-center">
                <h1>احدث اجهزة الاستقبال و الرسيفرات لشبكة بين سبورت</h1>
                <p class="col-lg-6 m-auto mt-3 mb-5">نقدم مجموعة من أفضل الأجهزة في العالم لمشاهدة أفضل وراحة أكثر, مع خدمات
                    تركيب رسيفر بي ان سبورت بالكويت, حيث نعتبر أكبر موزع بي ان سبورت الكويت. و الخليخ العربى</p>
            </div>

            <div class="devices row">
                @foreach ($devices as $device)
                    {{-- @if (count($device->newTypePackages) > 0) --}}
                        <div class="device col-lg-4 position-relative">
                            <div>
                                <a
                                    href="{{ route('device', $device->id) }}"><img
                                        src="{{ asset($device->image) }}" width="100%" height="400" alt=""></a>
                                <div class="box-device mx-4 mb-2 py-2 position-absolute bottom-0 start-0 end-0">
                                    <h5 class="my-3"><a
                                            href="{{ route('device', $device->id) }}"
                                            class="main-color-yellow-hover text-dark text-decoration-none">
                                            {{ $device->name }}
                                        </a>
                                    </h5>
                                    <p>{{ Str::limit($device->description, 30) }}</p>
                                    <a href="{{ route('device', $device) }}"><button class="main-button mb-2">
                                            <p class="position-relative m-0">معرفة المزيد</p>
                                        </button></a>
                                </div>
                            </div>
                        </div>
                    {{-- @endif --}}
                @endforeach
            </div>
        </div>
    </div>
    @if ($worldCup)
        <div class="main-background-color scrolling ad-container"
            style="background-image: url({{ asset('resources/front/images/150959.jpg') }});">
            <div class="container">
                <div class="world-cup mt-5">
                    <div class="row px-5 py-5">
                        <div class="col-lg-6 align-items-center">
                            <h1 class="m-0 text-light">{{ $worldCup['name'] }}</h1>
                        </div>
                        <div class="col-lg-6 d-flex flex-wrap flex-wrap text-start">
                            <a href="{{ route('product', ['id' => $worldCup->value, 'type' => 'renew']) }}"><button
                                    class="main-button bg-warning">
                                    <p class="text-light position-relative m-0">معرفة المزيد</p>
                                </button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="last-news-container py-5 scrolling mt-5" style="background-color: #ededede3;">
        <div class="container">
            <div class="subtitle text-center">
                <h1>آخر الأخبار</h1>
                <p class="w-50 m-auto mt-3 mb-5">نقوم بعرض بعض الخدمات الحديثة و العروض المتقدمة لكل متابعين الموقع الخاص
                    بنا
                    <a href="{{ route('articles') }}" class="text-decoration-none">رؤية المزيد</a>
                </p>
            </div>
            <div class="row packages-beinsport">
                @foreach ($lastNews as $item)
                    <div class="col-lg-4 package-beinsport mb-5">
                        <div class="shadow">
                            <div class="package-image position-relative">
                                <a href="{{ route('article', $item->id) }}">
                                    <div
                                        class="direct-package position-absolute bottom-0 w-100 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-share-square text-light fs-3"></i>
                                    </div>
                                </a>
                                <a href="{{ route('article', $item->id) }}">
                                    <img src="{{ asset($item->image) }}" width="100%" alt="">
                                </a>
                                <div class="date-package position-absolute">
                                    <p class="m-0 text-center py-2 fs-5 bg-white text-dark">
                                        {{ $item->created_at->translatedFormat('d') }}</p>
                                    <p class="m-0 text-center py-2 main-background-color text-light">
                                        {{ $item->created_at->translatedFormat('F') }}</p>
                                </div>
                            </div>
                            <div class="package-details bg-white p-4 position-relative">
                                <h3 class="my-3"><a href="{{ route('article', $item->id) }}"
                                        class="main-color-yellow-hover text-dark text-decoration-none">
                                        {{ $item->name }}
                                    </a></h3>

                                <p>{{ Str::limit(strip_tags($item->content), 40) }}</p>
                                <a href="{{ route('article', $item->id) }}"><button class="main-button mb-2">
                                        <p class="position-relative m-0">معرفة المزيد</p>
                                    </button></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
