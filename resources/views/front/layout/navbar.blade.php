{{-- <div class="tobar dark-color scrolling  py-3">
    <div class="container d-flex flex-row-reverse flex-wrap">
        <div class="text-light me-4"><i class="fa fa-phone-alt main-color"></i> 999887</div>
        <div class="text-light me-4"><i class="fa fa-envelope main-color"></i> example@example.com</div>
        <div class="text-light me-4"><i class="fa fa-globe-europe main-color"></i> ش. سالم المبارك / السالمية / الكويت
        </div>
    </div>
</div> --}}

<div class="logo scrolling py-3 bg-white border-bottom  text-end">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <img src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}" width="200px" height="50px"
                alt="">
            <div class="menu-toggle-navbar">
                <i class="fa fa-bars text-dark fs-3" id="menu_icon" style="cursor: pointer;"></i>
                <i class="fa fa-times text-dark fs-3" id="menu_close" style="cursor: pointer;display: none;"></i>
            </div>
        </div>
    </div>
</div>

<div class="navbar-container navbar-scrolling">
    <div class="container">
        <div class="navbar bg d-flex align-items-center py-4 px-5">
        <a href="#" class="navbar-brand ms-auto">
                                    <img src="{{ asset('resources/front/images/cropped-cropped-logo-1.png') }}" width="200px" height="50px"
                alt="">
                                    </a>
            <div @class([
                'navbar-items',
                'item-preview' => $is_preview,
            ])>
                <ul class="ul-list align-items-center list-unstyled ">
                
                    @if ($page != 'index')
                    <li><a href="{{ route('home') }}">الصفحة الرئيسية</a></li>
                    @endif
                    <li><a href="{{ route('offers') }}">العروض</a></li>
                    <li><a href="{{ route('products','renew') }}">تجديد الإشتراك </a></li>
                    <li><a href="{{ route('newSubscription') }}">إشتراك جديد </a></li>
                    @auth
                        <li><a href="{{ route('dashboard') }}">حسابي </a> </li>
                        <li> <a href="#logout" class="logout">تسجيل الخروج</a> </li>
                                {{--
                            <div class="dropdown p-3">
                                 <a href="#">الطلبات</a>
                                <hr class="bg-dark">
                                <a href="#">تفاصيل الحساب</a>
                                <hr class="bg-white"> 
                                <a href="{{ route('password.request') }}">نسيت كلمة المرور</a>
                                <hr class="bg-white">
                               
                            </div>
                                --}}
                       
                    @endauth
                    {{-- <li><a href="{{ route('completeOrder') }}">إتمام الطلب</a></li> --}}
                    {{-- <li><a href="{{ route('articles') }}">المقالات</a></li> --}}
                    {{-- <li><a href="{{ route('shoppingCart') }}">سلة المشتريات</a></li> --}}
                    @guest
                    <li> <a href="{{ route('login') }}" >تسجيل الدخول</a> </li>
                                    
                        <!-- <a href="" class="button-small-size"><button class="main-button my-3 bg-dark">
                                <p class="position-relative m-0">تسجيل/ تسجيل الدخول</p>
                            </button></a> -->
                    @endguest
                </ul>
            </div>
            <div class="scrolling px-3 button-large-size">
                @guest
                        <!-- <a href="{{ route('login') }}"><button class="main-button my-3 bg-dark">
                                <p class="position-relative m-0">تسجيل/ تسجيل الدخول</p>
                            </button></a> -->
                @endguest
                @auth
                @if ($is_preview)
                <a href="{{  url()->previous() }}"><button class="main-button bg-dark">
                    <p class="position-relative m-0">العودة إلى الصفحة السابقة</p>
                </button></a>
                @else
                    <div class="ain-button my-4">
                        <br>
                    </div>
                    @endif
                @endauth

            </div>
        </div>
    </div>
</div>
