@extends('dashboard.layout.layout')
@section('title', $title ?? 'Dashboard')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-12">
                    <h6 class="m-0 font-weight-bold text-primary">تعديل الملف الشخصي</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="form" action="{{ route('update_user_info') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <x-upload-image :type="1" :object="$user" :delete-image="route('delete_user_image')" />
                    </div>
                    <div class="form-group col-lg-12">
                        <label>الاسم الأول</label>
                        <input type="text" class="form-control" autocomplete="off" name="first_name" id="first_name"
                            value="{{ $user->first_name }}" required>
                    </div>
                    <div class="form-group mt-3 col-lg-12">
                        <label>الاسم الأخير</label>
                        <input type="text" class="form-control" autocomplete="off" name="last_name" id="last_name"
                            placeholder value="{{ $user->last_name }}" required>
                    </div>
                    <div class="form-group mt-3 col-lg-12">
                        <label>رقم التليفون</label>
                        <input type="text" class="form-control numeric" autocomplete="off" name="mobile" id="mobile"
                            value="{{ $user->mobile }}" required>
                    </div>
                    <div class="form-group mt-3 col-lg-12">
                        <label> كلمة المرور الجديدة</label>
                        <input type="password" class="form-control" autocomplete="off" name="password" id="password">
                    </div>
                    <div class="form-group mt-3 col-lg-12">
                        <label> تأكيد كلمة المرور الجديدة</label>
                        <input type="password" class="form-control" autocomplete="off" name="confirm_password"
                            id="confirm_password">
                    </div>
                </div>
                <button class="btn btn-primary mt-3">حفظ</button>
            </form>
            <hr>

        </div>
    </div>

@endsection
@section('page_js')
    <script src="{{ asset('resources/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/validate_userInfo.js') }}"></script>
    <script src="{{ asset('resources/assets/js/content/change_image.js') }}"></script>
@endsection
