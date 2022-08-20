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
                <div class="col-12">

                </div>
                <div class="col-12 table-responsive">
                    <table class="table table-hover w-100" id="packages">
                        <thead>
                            <tr>
                                <th></th>
                                <th>الاسم</th>
                                <th>الصورة</th>
                                <th>السعر</th>
                                <th>الجهاز</th>
                                <th>القنوات</th>
                                <th>صور القنوات</th>
                                <th>التعليقات</th>
                                <th>Actions</th>
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
<script>
    var delete_item="{{route('package.delete')}}";
    var delete_comment="{{route('comment.delete')}}";
    var is_offer="{{$offers?'?offers=true':''}}";
</script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js" ></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('resources/assets/js/content/packages.js')}}"></script>
<script src="{{ asset('resources/assets/js/content/commentsControl.js')}}"></script>
<script src="{{ asset('resources/assets/js/content/remove.js')}}"></script>
@endsection
