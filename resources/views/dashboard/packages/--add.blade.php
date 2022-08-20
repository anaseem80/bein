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
            @if ($is_sub)
                <li class="breadcrumb-item"><a href="{{ route('package.index') . '?subpackages=true' }}">الباقات
                        الفرعية</a></li>
            @else
                <li class="breadcrumb-item"><a href="{{ route('package.index') }}">الباقات الرئيسية</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
        </ol>
    </nav>
</div>
<div class="row">
    @if (!$is_sub)
        <div @class([
            'col-lg-12' => $action == 'add',
            'col-lg-7' => $action == 'update',
        ])>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="m-0 font-weight-bold text-primary position-relative">
                                {{ $title }}
                                @if ($action == 'update')
                                    <button type="button" id="addSubPackageBtn"
                                        class="btn btn-primary position-absolute top-50 translate-middle" style="left:0"
                                        data-bs-toggle="modal" data-bs-target="#addSubPackage">إضافة باقة فرعية</button>
                                @endif
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <x-package-form :action="$action" :is-sub="$is_sub" :sub-action="''"
                        :package="isset($package)?$package:null" :parent-id="null" :is-parent="true"
                        :main-packages="$mainPackages" :channels="$channels" :devices="$devices" />

                </div>
            </div>
        </div>
        @if ($action == 'update')
            <div class="modal fade" id="addSubPackage" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">إضافة باقة جديدة</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <x-package-form :action="$action" :is-sub="$is_sub" :sub-action="'add'"
                                :package="isset($package)?$package:null" :parent-id="$package->id" :is-parent="false"
                                :main-packages="$mainPackages" :channels="$channels" :devices="$devices" />
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
    @if (!$is_sub && $action == 'update')
        <div class="col-lg-5">
            @if ($action == 'update')
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    الباقات الفرعية
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group col-12 mt-3">
                            @if (count($package->subPackages) == 0)
                                <span class="text-secondary d-block">
                                    لا يوجد باقات فرعية
                                </span>
                            @else
                                <div class="accordion mt-2" id="accordionExample">
                                    @foreach ($package->subPackages as $sub)
                                        <div class="accordion-item mt-1" id="package-{{ $sub->id }}">
                                            <h2 class="accordion-header alert-success d-flex"
                                                id="headingP{{ $sub->id }}">
                                                <i class="fa fa-trash text-danger m-auto ms-3 fs-6 remove"
                                                    data-id="{{ $sub->id }}" data-type="package"
                                                    style="cursor: pointer;" title="حذف الباقة"></i>
                                                <button class="accordion-button alert-success collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapseP{{ $sub->id }}" aria-expanded="false"
                                                    aria-controls="collapseP{{ $sub->id }}">
                                                    {{ $sub->name }}
                                                </button>
                                            </h2>
                                            <div id="collapseP{{ $sub->id }}" class="accordion-collapse collapse"
                                                aria-labelledby="headingP{{ $sub->id }}"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <x-package-form :action="'update'" :is-sub="$is_sub"
                                                        :sub-action="'edit'" :package="isset($sub)?$sub:null"
                                                        :parent-id="$package->id" :is-parent="false"
                                                        :main-packages="$mainPackages" :channels="$channels"
                                                        :devices="$devices" />
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif
    @if ($is_sub)
        <div @class([
            'col-md-12' => $is_sub,
        ])>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="m-0 font-weight-bold text-primary">
                                @if ($is_sub)
                                    {{ $title }}
                                @else
                                    إضافة باقة فرعية
                                @endif
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <x-package-form :action="$action" :is-sub="$is_sub" :sub-action="'add'"
                        :package="isset($package)?$package:null"
                        :parent-id="$is_sub?($action=='update'?$package->parent_id:null):$package->id"
                        :is-parent="false" :main-packages="$mainPackages" :channels="$channels" :devices="$devices" />
                    <hr>
                </div>
            </div>
        </div>
    @endif
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
            id:"{{ $device->id }}",
            image:"{{ $device->image }}"
            })
        @endforeach
    @endisset
    @isset($channels)
        @foreach ($channels as $channel)
            channels.push({
            id:"{{ $channel->id }}",
            image:"{{ $channel->image }}"
            })
            var channel_item={};
            channel_item.channel_id="{{ $channel->id }}";
            channel_item.images=[];
            @foreach ($channel->images as $image)
                channel_item.images.push({
                id:"{{ $image->id }}",
                image:"{{ $image->image }}"
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
