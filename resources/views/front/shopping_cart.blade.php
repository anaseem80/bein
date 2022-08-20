@extends('front.layout.layout',['currency','currency'])
@section('title', isset($title) ? $title : '')
@section('content')
    <div class="py-5 scrolling">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 shopping-cart-main-container">
                    <div class="table-shopping">
                        <table class="table" id="cartTable">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col">المنتج</th>
                                    <th scope="col">السعر</th>
                                    <th scope="col">الكمية</th>
                                    <th scope="col">المجموع</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <div class="d-flex align-items-center">
                                            <input type="text" class="form-control ms-3" placeholder="رمز القسيمة"
                                                style="width: 100px;height: 45px;">
                                            <button class="main-button my-3">
                                                <p class="position-relative m-0">استخدام القسيمة</p>
                                            </button>
                                        </div>
                                    </td>
                                    <td colspan="3" class="text-start">
                                    <button class="main-button my-3 bg-danger" id="refreshCart">
                                            <p class="position-relative m-0">تحديث السلة</p>
                                        </button></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="shopping-total mt-5">
                        <h3 class="mb-3">إجمالي سلة المشتريات</h3>
                        <table class="table border noDataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="border">المجموع</th>
                                    <td scope="col"><span id="cartSubtotal"></span> <x-currency/></td>
                                </tr>
                                <tr>
                                    <th scope="col" class="border">الشحن</th>
                                    <th scope="col" class="border">شحن مجاني <br> سيتم تحديث خيارات الشحن أثناء
                                        السداد.</th>
                                </tr>
                                <tr>
                                    <th scope="col" class="border">الإجمالي</th>
                                    <th scope="col" class="border"><span id="cartTotal"></span> <x-currency/> </th>
                                </tr>
                            </thead>
                        </table>
                        <a href="{{route('completeOrder')}}"><button class="main-button my-3 w-100 bg-warning">
                                <p class="position-relative m-0">التقدم لإتمام الطلب</p>
                            </button></a>
                    </div>
                </div>
                @include('front.layout.comments-latestarticles')
            </div>
        </div>
    </div>
@endsection
@section('page_js')
<script>
    initCartTable('#cartTable');
</script>
{{--
<script>
var delete_item="{{route('remove_from_cart')}}";
var change_cart_count="{{route('change_cart_count')}}";
</script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js" ></script>
<script src="{{ asset('resources/assets/js/content/remove.js')}}"></script>
<script src="{{asset('resources/assets/js/content/cart.js')}}"></script> --}}
@endsection
