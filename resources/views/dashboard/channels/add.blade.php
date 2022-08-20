@extends('dashboard.layout.layout')
@section('title', $title ?? 'Dashboard')
@section('content')

    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('channel.index') }}">القنوات</a></li>
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
                <form id="form" action="{{ route('channel.store') }}" method="post" enctype="multipart/form-data">
                @else
                    <form id="form" action="{{ route('channel.update', $channel) }}" method="post"
                        enctype="multipart/form-data">
                        @method('PUT')
            @endif
            @csrf
            <div class="row">
                <div class="col-12">
                    <x-upload-image :type="$action=='update'?1:0" :object="$action=='update'?$channel:null"
                        :delete-image="route('delete_channel_image')" />
                </div>
                <div class="form-group col-lg-12">
                    <label>الاسم</label>
                    <input type="text" class="form-control" autocomplete="off" name="name" id="name"
                        value="{{ $action == 'update' ? $channel->name : '' }}" required>
                </div>
                <div class="form-group mt-3 col-lg-12">
                    <label>الوصف</label>
                    <textarea class="form-control" autocomplete="off" name="description" id="description"
                        placeholder>{{ $action == 'update' ? $channel->description : '' }}</textarea>
                </div>
                <div class="form-group mt-3 col-lg-12">
                    <label>عدد القنوات</label>
                    <input type="text" class="form-control numeric" autocomplete="off" name="amount" id="amount"
                        value="{{ $action == 'update' ? $channel->amount : '' }}" required>
                </div>
                <div class="form-group mt-3 col-lg-12">
                    <label>إضافة صور</label>
                    <input type="file" class="form-control" name="images[]" id="images" multiple accept="image/*" />
                    @if ($action == 'update')
                        <div class="p-2 mt-3">
                            <label>معرض الصور</label>
                            <table class="table table-striped" id="channel_images">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>الصورة</th>
                                        <th>حذف</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
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
    <script>
        @if ($action == 'update')
            var channel_id="{{ $channel->id }}"
        @endif
        var delete_item = "{{ route('delete_channel_images') }}";
    </script>
    <script src="{{ asset('resources/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/validate_channel.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/change_image.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('resources/assets/js/content/channel_images.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/remove.js') }}"></script>
@endsection
