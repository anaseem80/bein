@extends('dashboard.layout.layout')
@section('title', $title ?? 'Dashboard')
@section('content')
@section('page_css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
@endsection
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">لوحة التحكم</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
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
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="package_type" value="both" checked>
                            جميع الطلبات</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="package_type" value="new">
                            اشتراك جديد</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="package_type" value="renew">
                            تجديد اشترك</label>
                    </div>
                </div>
                <div class="col-12 table-responsive">
                    <table class="table table-hover w-100" id="orders">
                        <thead>
                            <tr>
                                <th></th>
                                <th>التاريخ</th>
                                <th>العضو</th>
                                <th>الاسم الأول</th>
                                <th>الاسم الأخير</th>
                                <th>البريد الاليكتروني</th>
                                <th>الهاتف</th>
                                <th>الدولة</th>
                                <th>رقم الطلب</th>
                                <th>رقم الفاتورة</th>
                                <th>رقم العملية</th>
                                <th>حالة الفاتورة</th>
                                <th>المدة</th>
                                <th>نوع الاشتراك</th>
                                <th>Bein card number</th>
                                <th>الباقة</th>
                                <th>سعر الباقة</th>
                                <th>الجهاز</th>
                                <th>سعر الجهاز</th>
                                <th>مصاريف الشحن</th>
                                <th>إجمالي الضريبة</th>
                                <th>الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('page_js')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js" ></script>
<script src="{{ asset('resources/assets/js/content/orders.js')}}"></script>
@endsection
