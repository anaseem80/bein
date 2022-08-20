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
                <div class="col-12 mb-3 row">
                    <div class="col-8">
                        <input type="text" class="form-control numeric" placeholder="أدخل رقم الكارت" id="newCard" />
                    </div>
                    <div class="col-4">
                        <button class="btn btn-primary" id="addNewCard">إضافة</button>
                    </div>
                </div>
                <div class="col-12 table-responsive">
                    <table class="table table-hover w-100" id="beinCards">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Bein Card Number</th>
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
    var delete_item="{{route('beinCard.delete')}}";
    var add_new_card="{{route('beinCard.store')}}";
    var update_card="{{route('beinCard.updated')}}";
</script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js" ></script>
<script src="{{ asset('resources/assets/js/content/beinCards.js')}}"></script>
<script src="{{ asset('resources/assets/js/content/remove.js')}}"></script>
@endsection
