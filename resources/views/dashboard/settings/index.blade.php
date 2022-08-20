@extends('dashboard.layout.layout')
@section('title', $title ?? 'Dashboard')
@section('page_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <style>
        .select2-container {
            z-index: 100000000;
        }
    </style>
@endsection
@section('content')
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="#info">معلومات الموقع</a> |
                    <a href="#social">وسائل التواصل</a> |
                    <a href="#taxes">المصاريف الإضافية</a> |
                    <a href="#sliders">الغلاف</a> |
                    <a href="#mainPackages">أهم الباقات </a> |
                    <a href="#worldCup">باقة كأس العالم </a>
                </li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3" id="info">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="m-0 font-weight-bold text-primary">
                                معلومات الموقع
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <form id="form" action="{{ route('setting.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="info">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group image-container">
                                    <div class="form-group hidden">
                                        <input type="file" name="logo" placeholder="Choose image" class="image"
                                            accept="image/*">
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 d-flex justify-content-center align-items-center">
                                            <div class="image-upload">
                                                <img data-id="{{ $info['logo']->id }}" data-type="1"
                                                    class="image_preview_container"
                                                    src="{{ asset($info['logo']->value ?? 'resources/assets/img/upload-image.png') }}"
                                                    alt="preview image">
                                                <div class="remove-image">
                                                    <button type="button" class="remove-image-button">
                                                        <i class="fa fa-times"></i></button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 mt-2">
                                <label>لون قائمة لوحة التحكم</label>
                                <input type="color" class="form-control" autocomplete="off" name="sidebar_color"
                                    id="sidebar_color" value="{{ $info['sidebar_color']->value }}">
                            </div>
                            <div class="form-group col-lg-12 mt-2">
                                <label>رقم التليفون</label>
                                <input type="text" class="form-control numeric" autocomplete="off" name="telephone"
                                    id="telephone" value="{{ $info['telephone']->value }}">
                            </div>
                            <div class="form-group col-lg-12 mt-3">
                                <label>البريد الاليكتروني</label>
                                <input type="email" class="form-control" autocomplete="off" name="email" id="email"
                                    value="{{ $info['email']->value }}">
                            </div>
                            <div class="form-group col-lg-12 mt-3">
                                <label>العملة المعروضة في الموقع</label>
                                <input required type="text" class="form-control text-start" autocomplete="off"
                                    name="currency" id="currency" value="{{ $info['currency']->value }}">
                            </div>
                            <div class="form-group col-lg-12 mt-3">
                                <label>عملة الدفع</label>
                                <input required type="text" class="form-control text-start" autocomplete="off"
                                    name="pay_currency" id="currency" value="{{ $info['pay_currency']->value }}">
                            </div>
                            <div class="form-group col-lg-12 mt-3">
                                <label>مدة توصيل الطلب (باليوم)</label>
                                <input type="text" class="form-control text-start numeric" autocomplete="off"
                                    name="shipping_duration" id="shipping_duration"
                                    value="{{ $info['shipping_duration']->value }}">
                            </div>
                            <div class="form-group col-lg-12 mt-3">
                                <label>صورة غلاف الباقات الإفتراضية</label>
                                <i>سيتم حفظ الصورة بأبعاد 1366px*300px</i>

                                <input type="file" class="form-control" accept="image/*" name="packages_cover"
                                    id="packages_cover" />
                                @if ($info['packages_cover']->value)
                                    <div class="p-5">
                                        <img src="{{ asset($info['packages_cover']->value) }}" class="w-100" />
                                        <label class="mt-2"><input type="checkbox" name="remove_cover" /> إزالة
                                            صورة الغلاف مع حفظ التغييرات؟</label>

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

        </div>
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3" id="social">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="m-0 font-weight-bold text-primary">
                                وسائل التواصل
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <form id="form" action="{{ route('setting.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <br>
                        <input type="hidden" name="type" value="social">
                        <div class="row">
                            @foreach ($social as $item)
                                <div class="input-group mt-3">
                                    <span class="input-group-text px-3" style="width:50px;" id="basic-addon1"><i
                                            class="fab fa-{{ $item->key }}"></i></span>
                                    <input type="text" class="form-control" value="{{ $item->value }}"
                                        name="{{ $item->key }}" placeholder="{{ ucfirst($item->key) }}"
                                        aria-label="{{ $item->key }}" aria-describedby="basic-addon1">
                                </div>
                            @endforeach

                        </div>
                        <div class="form-group mt-3 text-end">
                            <button class="btn btn-primary">حفظ</button>
                        </div>
                    </form>
                    <hr>

                </div>
            </div>

        </div>

        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3" id="taxes">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="m-0 font-weight-bold text-primary ps-5">
                                المصاريف الإضافية
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-hover" id="orderTaxes">
                                <thead class="table-dark">
                                    <tr>
                                        <th>العنوان</th>
                                        <th>القيمة</th>
                                        <th>نوع القيمة</th>
                                        <th>عرض في تفاصيل الطلب</th>
                                        <th>تفعيل</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>

                </div>

            </div>

        </div>



        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="m-0 font-weight-bold text-primary">
                                الصفحة الرئيسية
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="card-header py-3" id="slider">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="m-0 font-weight-bold text-primary ps-5">
                                الغلاف
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4">
                    <i>سيتم حفظ الصورة بأبعاد 768px*432px</i>
                    <input type="hidden" name="type" value="sliders">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-hover" id="sliders">
                                <thead class="table-dark">
                                    <tr>
                                        <th>الصورة</th>
                                        <th>العنوان</th>
                                        <th>رابط تجديد الاشتراك</th>
                                        <th>رابط الاشتراك الجديد</th>
                                        <th>نشر</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>

                </div>

                <div class="card-header py-3" id="mainPackages">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="m-0 font-weight-bold text-primary ps-5">
                                أهم الباقات
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4">
                    <form action="{{ route('setting.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="paragraphs">
                        <div class="row">
                            <div class="form-group col-10">
                                <label>الفقرة أعلى الباقات</label>
                                <textarea class="form-control" name="mainPackages">{{ $paragraphs['mainPackages']->value }}</textarea>
                            </div>
                            <div class="form-group col-2">
                                <br>
                                <button class="btn btn-success" type="submit">حفظ</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-hover" id="packages">
                                <thead class="table-dark">
                                    <tr>
                                        <th>الاسم</th>
                                        <th>الصورة</th>
                                        <th>السعر</th>
                                        <th>الوصف</th>
                                        <th>نشر</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>

                </div>



                <div class="card-header py-3" id="worldCup">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="m-0 font-weight-bold text-primary ps-5">
                                باقة كأس العالم
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4">
                    <div class="row">
                        <div class="col-12">
                            <form method="POST">
                                @csrf
                                <input type="hidden" name="type" value="worldCup" />
                                <div class="form-group">
                                    <label>اختيار باقة كأس العالم</label>
                                    <div
                                        class="form-check form-switch d-inline-flex justify-content-center align-items-center">
                                        <input name="status" value="1"
                                            title="{{ $worldCup['worldCup']->status == 1 ? 'إلغاء النشر' : 'نشر' }}"
                                            style="cursor:pointer" class="form-check-input change-published"
                                            {{ $worldCup['worldCup']->status == 1 ? 'checked' : '' }} type="checkbox">
                                    </div>
                                    <select class="form-control select2" name="worldCup">
                                        <option value="">بدون</option>
                                        @foreach ($packages as $package)
                                            <option value="{{ $package->id }}"
                                                @if ($worldCup['worldCup']->value == $package->id) selected @endif>{{ $package->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mt-3 text-end">
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>

                </div>


            </div>

        </div>
    </div>
@endsection
@section('page_js')
    <script>
        var delete_image = "{{ route('delete_setting_image') }}";
        var storeSlider = "{{ route('storeSlider') }}";
        var storeMainPackage = "{{ route('storeMainPackage') }}";
        var storeTax = "{{ route('storeTax') }}";
        var change_published = "{{ route('changeSettingStatus') }}";
        var change_tax = "{{ route('changeTax') }}";
        var delete_item = "{{ route('setting.delete') }}";
        var packages = [];
        @foreach ($packages as $package)
            packages.push({
                id: "{{ $package->id }}",
                name: "{{ $package->name }}",
                logo: "{{ $package->image }}",
                price: "{{ $package->price }}",
            })
        @endforeach
    </script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('resources/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/change_image.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/sliders-packages.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/commentsControl.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/remove.js') }}"></script>

@endsection
