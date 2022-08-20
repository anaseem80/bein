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
        <div class="py-5 scrolling">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 product-main-container">
                        <div>
                            <h3>تفاصيل الفاتورة</h3>
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="fname">الاسم الاول <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" required id="fname" class="form-control" value="{{$user?->first_name}}">
                                </div>
                                <div class="col-lg-6">
                                    <label for="lname">الاسم الاخير <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" required id="lname" class="form-control" value="{{$user?->last_name}}">
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="select-state">الدولة / المنطقة <span class="text-danger">*</span></label>
                                <x-countries />
                            </div>
                            <div class="form-group mt-3">
                                <label for="street">عنوان الشارع / الحي <span class="text-danger">*</span></label>
                                <input type="text" name="address" id="street" required class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label for="town">المدينة <span class="text-danger">*</span></label>
                                <input type="text" name="city" id="town" required class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label for="zipcode">الرمز البريدي <span class="text-danger">*</span></label>
                                <input type="text" name="zip_code" required id="zipcode" class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label for="phonenubmer">الهاتف <span class="text-danger">*</span></label>
                                <input type="text" name="mobile" required id="phonenubmer" class="form-control numeric" value="{{$user?->mobile}}">
                            </div>
                            <div class="form-group mt-3">
                                <label for="email">البريد الالكتروني <span class="text-danger">*</span></label>
                                <input type="email" name="email" required id="email" class="form-control" value="{{$user?->email}}">
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
                                    @php($subTotal=0)
                                    @php($offers=0)
                                    @php($shipping=0)
                                    @foreach($items as $item)
                                    <tr>
                                        <th scope="col" class="border">{{$item->name}} &times; {{$item->count}}</th>
                                        <th scope="col" class="border">{{$item->price*$item->count}} <x-currency /></th>
                                    </tr>
                                    @php($subTotal+=$item->price*$item->count)
                                    @endforeach
                                    <tr>
                                        <th scope="col" class="border">المجموع</th>
                                        <th scope="col" class="border">{{$subTotal}} <x-currency /></th>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="border">الشحن</th>
                                        <th scope="col" class="border">شحن مجاني</th>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="border">الإجمالي</th>
                                        <th scope="col" class="border">{{$subTotal+$shipping-$offers}} <x-currency /></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="payment p-3 bg-light border-rounded">
                            <div class="payment-way">
                                <input type="radio">
                                <span>tap</span>
                                <div>
                                    <!-- Here payment API -->
                                </div>
                            </div>
                        </div>
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
    <script src="{{ asset('resources/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/completeOrder.js') }}"></script>
    <script>
        $('.select2').select2()
    </script>
@endsection
