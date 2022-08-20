@extends('dashboard.layout.layout')
@section('title', $title ?? 'Dashboard')
@section('content')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('resources/assets/summernote/summernote.min.css') }}">

    <style>
        .accordion-button::after {
            margin-left: 0 !important;
        }

        .accordion-button {
            outline: none !important;
            user-select: none !important;
            box-shadow: none !important;
        }

        .accordion-button:not(.collapsed) {
            background-color: unset !important;
        }

        .select2-container {
            z-index: 1080 !important;
        }

    </style>
@endsection
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
            <li class="breadcrumb-item"><a href="{{ route('package.index') }}">الباقات </a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-12">
                        <h6 class="m-0 font-weight-bold text-primary position-relative">
                            {{ $title }}

                        </h6>
                    </div>
                </div>
            </div>
            <div class="card-body">

                @if ($action == 'add')
                    <form class="form1" id="form" action="{{ route('package.store') }}" method="post"
                        enctype="multipart/form-data">
                    @else
                        <form class="form1" id="form" action="{{ route('package.update', $package) }}" method="post"
                            enctype="multipart/form-data">
                            @method('PUT')
                @endif
                @csrf
                <div class="row">
                    <div class="col-12">
                        <i>سيتم حفظ الصورة بأبعاد 200px*200px</i>
                        <x-upload-image :type="$action == 'update' ? 1 : 0" :object="$action == 'update' ? $package : null" :delete-image="route('delete_package_image')" />
                    </div>
                    <div class="form-group col-lg-12">
                        <label>الاسم</label>
                        <input type="text" class="form-control" autocomplete="off" name="name"
                            value="{{ $action == 'update' ? $package->name : '' }}" required>
                    </div>
                    <div class="form-group col-lg-12">
                        <label>
                            <input type="checkbox" autocomplete="off" name="is_offer"
                                {{ $action == 'update' ? ($package->is_offer ? 'checked' : '') : '' }}>
                            عرض ؟</label>
                    </div>
                    <div class="form-group mt-3 col-lg-12">
                        <label>الوصف</label>
                        <textarea class="form-control summernote" autocomplete="off"
                            name="description">{{ $action == 'update' ? $package->description : '' }}</textarea>
                    </div>
                    <h3 class="mt-3">أسعار الإشتراكات</h3>
                    <div class="form-group mt-3 col-lg-12">
                        <label>90 يوم</label>
                        <input type="text" class="form-control numeric" name="price_90"
                            value="{{ $action == 'update' ? $package->price_90 : '' }}" />
                    </div>
                    <div class="form-group mt-3 col-lg-12">
                        <label>180 يوم</label>
                        <input type="text" class="form-control numeric" name="price_180"
                            value="{{ $action == 'update' ? $package->price_180 : '' }}" />
                    </div>
                    <div class="form-group mt-3 col-lg-12">
                        <label>365 يوم</label>
                        <input type="text" class="form-control numeric" name="price_365"
                            value="{{ $action == 'update' ? $package->price_365 : '' }}" />
                    </div>
                    <div class="mt-3 col-lg-12">
                        <hr>
                    </div>
                    <h3 class="mt-3">عرض في</h3>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" value="new" id="new"
                            @if ($action == 'update') @if ($package->type == 'new') checked @endif
                            @endif>
                        <label class="form-check-label" for="new"> اشتراك جديد</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" value="renew" id="renew"
                            @if ($action == 'update') @if ($package->type == 'renew') checked @endif
                            @endif>
                        <label class="form-check-label" for="renew"> تجديد اشتراك (لا يتم عرض
                            الجهاز)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" value="both" id="both"
                        @if ($action == 'update') @if ($package->type == 'both') checked @endif @else
                            checked @endif>
                        <label class="form-check-label" for="both"> كليهما</label>
                    </div>
                    {{-- <div class="form-group mt-3 col-lg-12">
                        <label>الجهاز</label>
                        <select class="form-control select2 devices" name="device_id">
                            <option value="" @if ($action == 'add') selected @endif disabled>اختر جهاز
                            </option>
                            <option value="">بدون</option>
                            @foreach ($devices as $device)
                                <option value="{{ $device->id }}"
                                    @if ($action == 'update') @if ($package->device_id == $device->id) selected @endif
                                    @endif>
                                    {{ $device->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    {{-- <div class="form-group mt-3 col-lg-12">
                        <label>سعر الجهاز</label>
                        <input type="text" class="form-control numeric" name="price_device"
                            value="{{ $action == 'update' ? $package->price_device : '' }}" />
                    </div> --}}

                    <div class="form-group mt-3 col-lg-12">
                        <label>الأجهزة</label>

                        <?php
                        $ids_d = [];
                        if ($action == 'update') {
                            foreach ($package->devices as $d) {
                                array_push($ids_d, $d->id);
                            }
                        }
                        ?>
                        <select class="form-control select2 devices"
                            data-id="{{ $action == 'update' ? $package->id : 0 }}" name="devices[]"
                            id="devicesP{{ $action == 'update' ? $package->id : 0 }}" multiple>
                            @foreach ($devices as $device)
                                <option value="{{ $device->id }}"
                                    @if (count($ids_d) > 0) @if (in_array($device->id, $ids_d)) selected @endif
                                    @endif>
                                    {{ $device->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3 col-lg-12">
                        <label>القنوات</label>

                        <?php
                        $ids = [];
                        if ($action == 'update') {
                            foreach ($package->channels as $ch) {
                                array_push($ids, $ch->id);
                            }
                        }
                        ?>
                        <select class="form-control select2 channels"
                            data-id="{{ $action == 'update' ? $package->id : 0 }}" name="channels[]"
                            id="channelsP{{ $action == 'update' ? $package->id : 0 }}" multiple>
                            @foreach ($channels as $channel)
                                <option value="{{ $channel->id }}"
                                    @if (count($ids) > 0) @if (in_array($channel->id, $ids)) selected @endif
                                    @endif>
                                    {{ $channel->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="form-group mt-3">
                    <button type="button" class="btn btn-warning w-25" data-bs-toggle="modal"
                        data-bs-target="#channelImages{{ $action == 'update' ? $package->id : 0 }}">صور القنوات
                        <span
                            id="imagesCount{{ $action == 'update' ? $package->id : 0 }}">{{ $action == 'update' ? '(' . count($package->channelImages) . ')' : '(0)' }}</span>
                    </button>
                    <div class="modal fade" id="channelImages{{ $action == 'update' ? $package->id : 0 }}"
                        tabindex="-1" style="background:rgba(100,100,100,.7);z-index:1100"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">صور القنوات</h5>
                                    <button type="button" class="btn-close"
                                        onclick="$(`#channelImages{{ $action == 'update' ? $package->id : 0 }}`).modal('hide')"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body"
                                    id="channelImagesView{{ $action == 'update' ? $package->id : 0 }}">
                                    @if ($action == 'update')
                                        <?php
                                        $imgIds = [];
                                        foreach ($package->channelImages as $img) {
                                            array_push($imgIds, $img->id);
                                        }
                                        ?>
                                        @foreach ($package->channels as $ch)
                                            @if (count($ch->images) > 0)
                                                <div id="channelView{{ $package->id }}-{{ $ch->id }}">
                                                    <h3>{{ $ch->name }}</h3>
                                                    <button type="button" class="btn btn-primary checkAll"
                                                        id="checkBtn{{ $ch->id }}"
                                                        data-channel_id="{{ $ch->id }}"
                                                        data-id="{{ $package->id }}" data-type="uncheck">إلغاء
                                                        تحديد الكل</button>
                                                    <div id="channels-{{ $ch->id }}" class="row mb-5">
                                                        @foreach ($ch->images as $img)
                                                            <div class="col-3 mt-2">
                                                                <input id="ch{{ $img->id }}"
                                                                    data-channel_id="{{ $ch->id }}"
                                                                    data-id="{{ $package->id }}" type="checkbox"
                                                                    @if (in_array($img->id, $imgIds)) checked @endif
                                                                    name="images[]" class="checkImage" multiple
                                                                    value="{{ $img->id }}">
                                                                <label for="ch{{ $img->id }}"><img width="50"
                                                                        height="50"
                                                                        src="{{ asset($img->image) }}"></label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        onclick="$(`#channelImages{{ $action == 'update' ? $package->id : 0 }}`).modal('hide')">إغلاق</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <hr>
                    <h3 class="mt-3">صورة الغلاف</h3>
                    <i>سيتم حفظ الصورة بأبعاد 1366px*300px</i>
                    <input type="file" name="cover" class="form-control" accept="image/*" />
                    @if ($action == 'update')
                        @if ($package->cover)
                            <div class="p-5">
                                <img src="{{ asset($package->cover) }}" class="w-100" />
                                <label class="mt-2"><input type="checkbox" name="remove_cover" /> إزالة صورة الغلاف مع حفظ التغييرات؟</label>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="form-group mt-3 text-end">
                    <button class="btn btn-primary">
                        حفظ
                    </button>
                </div>
                </form>


            </div>
        </div>
    </div>
</div>

@endsection
@section('page_js')

<script>
    var delete_item = "{{ route('package.delete') }}";
    var devices = [];
    var channels = [];
    var channel_images = [];
    @isset($devices)
        @foreach ($devices as $device)
            devices.push({
                id: "{{ $device->id }}",
                image: "{{ $device->image }}"
            })
        @endforeach
    @endisset
    @isset($channels)
        @foreach ($channels as $channel)
            channels.push({
                id: "{{ $channel->id }}",
                image: "{{ $channel->image }}"
            })
            var channel_item = {};
            channel_item.channel_id = "{{ $channel->id }}";
            channel_item.images = [];
            @foreach ($channel->images as $image)
                channel_item.images.push({
                    id: "{{ $image->id }}",
                    image: "{{ $image->image }}"
                });
            @endforeach
            channel_images.push(channel_item)
        @endforeach

    @endisset
</script>
<script src="{{ asset('resources/assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('resources/assets/js/content/validate_package.js') }}"></script>
<script src="{{ asset('resources/assets/js/content/change_image.js') }}"></script>
<script src="{{ asset('resources/assets/js/content/package.js') }}"></script>
<script src="{{ asset('resources/assets/js/content/remove.js') }}"></script>
<script src="{{ asset('resources/assets/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('resources/assets/summernote/lang/summernote-ar-AR.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 350,
            lang: 'ar-AR'
        });
    })
</script>
@endsection
