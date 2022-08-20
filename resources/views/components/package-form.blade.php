@if (!$isSub)
    @if ($subAction == 'edit')
        <form class="form1" action="{{ route('package.update', $package) }}" method="post"
            enctype="multipart/form-data">
            @method('PUT')
            <input type="hidden" name="parent_id" value="{{ $parentId }}">
        @else
            <form class="form1" action="{{ route('package.store') }}" method="post"
                enctype="multipart/form-data">
                @if (!$isParent)
                    <input type="hidden" name="parent_id" value="{{ $parentId }}">
                @endif
    @endif
@else
    @if ($action == 'add')
        <form class="form1" action="{{ route('package.store') }}" method="post" enctype="multipart/form-data">
        @else
            <form class="form1" action="{{ route('package.update', $package) }}" method="post"
                enctype="multipart/form-data">
                @method('PUT')
    @endif
@endif
@csrf
<div class="row">
    <div class="col-12">
        <x-upload-image
            :type="$subAction=='edit'?1:($isSub ?($action=='update'?1:0):($isParent?($action=='update'?1:0):0))"
            :object="$action=='update'?$package:null" :delete-image="route('delete_package_image')" />
    </div>
    @if ($isSub)
        @if (!$isParent)
            <input type="hidden" name="subpackages" value="true" />
            <div class="form-group col-lg-12">
                <label>الباقة الرئيسية</label>
                <select class="form-control" autocomplete="off" name="parent_id" id="name1" required>
                    <option disabled value="" @if ($action == 'add') selected @endif>برجاء اختيار باقة رئيسية</option>
                    @foreach ($mainPackages as $p)
                        <option value="{{ $p->id }}" @if ($action == 'update') @if ($package->parent_id == $p->id) selected @endif @endif>
                            {{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    @endif
    <div class="form-group col-lg-12">
        <label>الاسم</label>
        <input type="text" class="form-control" autocomplete="off" name="name"
            value="{{ $subAction == 'edit' ? $package->name : ($isParent && $action == 'update' ? $package->name : ($isSub && $action == 'update' ? $package->name : '')) }}"
            required>
    </div>
    <div class="form-group mt-3 col-lg-12">
        <label>الوصف</label>
        <textarea class="form-control summernote" autocomplete="off"
            name="description">{{ $subAction == 'edit' ? $package->description : ($isParent && $action == 'update' ? $package->description : ($isSub && $action == 'update' ? $package->description : '')) }}</textarea>
    </div>
    @if (!$isParent)
        <div class="form-group mt-3 col-lg-12">
            <label>المدة</label>
            <select class="form-control" autocomplete="off" name="duration">
                <option value="" @if (!$isSub || ($isSub && $action == 'add')) selected @endif disabled>اختر مدة</option>
                <option value="30" @if ($subAction == 'edit' || ($isSub && $action == 'update')) @if ($package->duration == '30') selected @endif @endif>30 يوم</option>
                <option value="90" @if ($subAction == 'edit' || ($isSub && $action == 'update')) @if ($package->duration == '90') selected @endif @endif>90 يوم</option>
                <option value="180" @if ($subAction == 'edit' || ($isSub && $action == 'update')) @if ($package->duration == '180') selected @endif @endif>180 يوم</option>
                <option value="365" @if ($subAction == 'edit' || ($isSub && $action == 'update')) @if ($package->duration == '365') selected @endif @endif>365 يوم</option>
            </select>
        </div>
        <div class="form-group mt-3 col-lg-12">
            <label>السعر</label>
            <input type="text" class="form-control numeric" autocomplete="off" name="price"
                value="{{ $subAction == 'edit' ? $package->price : ($isSub && $action == 'update' ? $package->price : '') }}"
                required>
        </div>
        <div class="form-group mt-3 col-lg-12">
            <label>الجهاز</label>
            <select class="form-control select2 devices" name="device_id">
                <option value="" @if (!$isSub || ($isSub && $action == 'add')) selected @endif disabled>اختر جهاز</option>
                @foreach ($devices as $device)
                    <option value="{{ $device->id }}" @if ($subAction == 'edit' || ($isSub && $action == 'update')) @if ($package->device_id == $device->id) selected @endif @endif>
                        {{ $device->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mt-3 col-lg-12">
            <label>القنوات</label>

            <?php
            $ids = [];
            if ($subAction == 'edit' || ($isSub && $action == 'update')) {
                foreach ($package->channels as $ch) {
                    array_push($ids, $ch->id);
                }
            }
            ?>
            <select class="form-control select2 channels" data-id="{{ $action == 'update' ? $package->id : 0 }}"
                name="channels[]" id="channelsP{{ $action == 'update' ? $package->id : 0 }}" multiple>
                @foreach ($channels as $channel)
                    <option value="{{ $channel->id }}" @if (count($ids) > 0) @if (in_array($channel->id, $ids)) selected @endif @endif>
                        {{ $channel->name }}</option>
                @endforeach
            </select>
        </div>
    @endif
</div>
@if (!$isParent)
    <div class="form-group mt-3">
        <button type="button" class="btn btn-warning w-25" data-bs-toggle="modal"
            data-bs-target="#channelImages{{ $action == 'update' ? $package->id : 0 }}">صور القنوات
            <span
                id="imagesCount{{ $action == 'update' ? $package->id : 0 }}">{{ $action == 'update' ? '(' . count($package->channelImages) . ')' : '(0)' }}</span>
        </button>
        <div class="modal fade" id="channelImages{{ $action == 'update' ? $package->id : 0 }}" tabindex="-1" style="background:rgba(100,100,100,.7);z-index:1100"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">صور القنوات</h5>
                        <button type="button" class="btn-close" onclick="$(`#channelImages{{ $action == 'update' ? $package->id : 0 }}`).modal('hide')"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="channelImagesView{{ $action == 'update' ? $package->id : 0 }}">
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
                                            id="checkBtn{{ $ch->id }}" data-channel_id="{{ $ch->id }}"
                                            data-id="{{ $package->id }}" data-type="uncheck">إلغاء
                                            تحديد الكل</button>
                                        <div id="channels-{{ $ch->id }}" class="row mb-5">
                                            @foreach ($ch->images as $img)

                                                <div class="col-3 mt-2">
                                                    <input id="ch{{ $img->id }}"
                                                        data-channel_id="{{ $ch->id }}"
                                                        data-id="{{ $package->id }}" type="checkbox"
                                                        @if (in_array($img->id, $imgIds)) checked @endif name="images[]" class="checkImage"
                                                        multiple value="{{ $img->id }}">
                                                    <label for="ch{{ $img->id }}"><img width="50" height="50"
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
                        <button type="button" class="btn btn-secondary" onclick="$(`#channelImages{{ $action == 'update' ? $package->id : 0 }}`).modal('hide')">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="form-group mt-3 text-end">
    <button class="btn btn-primary">
        @if ($isSub||$subAction == 'edit'||$isParent)
            حفظ
        @else
            إضافة
        @endif
    </button>
</div>
</form>
