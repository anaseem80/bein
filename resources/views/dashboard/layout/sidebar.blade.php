<?php
use App\Http\Controllers\SettingController;
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion text-start" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center p-3" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            {{-- logo here --}}
            {!! SettingController::getSettingValue('logo') ? '<img width="50" height="50" src="'.asset(SettingController::getSettingValue('logo')).'"/>' : '' !!}
        </div>
        <div class="sidebar-brand-text mx-3">
            Bein Sport
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link text-center" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        Interface
    </div> -->

    <!-- Nav Item - Pages Collapse Menu -->
    @manager
    @owner
    <li class="nav-item">
        <a class="nav-link" href="{{ route('usersList') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>المستخدمون والصلاحيات</span></a>
    </li>
    @endowner
    <li class="nav-item">
        <a class="nav-link" href="{{ route('setting.index') }}">
            <i class="fas fa-fw fa-cogs"></i>
            <span>إعدادات الموقع</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('orders') }}">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>الطلبات</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse1" aria-expanded="true"
            aria-controls="collapse1">
            <i class="fas fa-fw fa-tasks"></i>
            <span>الأجهزة</span>
        </a>
        <div id="collapse1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('device.index') }}">الأجهزة</a>
                <a class="collapse-item" href="{{ route('device.create') }}">إضافة جهاز جديد</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse2" aria-expanded="true"
            aria-controls="collapse1">
            <i class="fas fa-fw fa-tasks"></i>
            <span>القنوات</span>
        </a>
        <div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('channel.index') }}">القنوات</a>
                <a class="collapse-item" href="{{ route('channel.create') }}">إضافة قنوات جديدة</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse3" aria-expanded="true"
            aria-controls="collapse1">
            <i class="fas fa-fw fa-tasks"></i>
            <span>الباقات</span>
        </a>
        <div id="collapse3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('package.index') }}">الباقات </a>
                <a class="collapse-item" href="{{ route('package.create') }}">إضافة باقة جديدة</a>
                <a class="collapse-item" href="{{ route('package.index') }}?offers=true">العروض </a>
            </div>
        </div>
    </li>
   
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse31" aria-expanded="true"
            aria-controls="collapse1">
            <i class="fas fa-fw fa-tasks"></i>
            <span>العروض</span>
        </a>
        <div id="collapse31" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('offers.index') }}">العروض </a>
                <a class="collapse-item" href="{{ route('offers.create') }}">إضافة عرض جديد</a>
            </div>
        </div>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse4" aria-expanded="true"
            aria-controls="collapse1">
            <i class="fas fa-fw fa-tasks"></i>
            <span>الفئات</span>
        </a>
        <div id="collapse4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('category.index') }}">الفئات </a>
                <a class="collapse-item" href="{{ route('category.create') }}">إضافة فئة جديدة</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse5" aria-expanded="true"
            aria-controls="collapse1">
            <i class="fas fa-fw fa-tasks"></i>
            <span>المقالات</span>
        </a>
        <div id="collapse5" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('blog.index') }}">المقالات </a>
                <a class="collapse-item" href="{{ route('blog.create') }}">إضافة مقال جديد</a>
            </div>
        </div>
    </li>
    @owner
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse6" aria-expanded="true"
            aria-controls="collapse1">
            <i id="deletedComments" @class([
                'text-danger' => App\Http\Controllers\CommentController::deletedExist(),
                'fas fa-fw fa-trash',
            ])></i>
            <span>التعليقات المحذوفة</span>
        </a>
        <div id="collapse6" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('deleted.comments', 'packages') }}">الباقات </a>
                <a class="collapse-item" href="{{ route('deleted.comments', 'blogs') }}">المقالات</a>
            </div>
        </div>
    </li>
    @endowner
    @endmanager
    <li class="nav-item">
        <a class="nav-link" href="{{ route('beinCard.index') }}">
            <i class="fas fa-address-card"></i>
            <span>Bein Card Number</span></a>
    </li>
    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        Addons
    </div> -->

    <!-- Nav Item - Pages Collapse Menu -->


</ul>
