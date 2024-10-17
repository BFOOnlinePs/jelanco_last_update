@extends('home')
@section('title')
    الاعدادات
@endsection
@section('header_title')
    الاعدادات
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    الاعدادات
@endsection
@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('currency.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="far fa-dollar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">العملات</span>
                        {{--                        <span class="info-box-number">None</span> --}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('bank.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="fa fa-bank"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">البنوك</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('tasks_type.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="fa fa-tasks"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">أنواع المهام</span>
                        {{--                        <span class="info-box-number">None</span> --}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('shipping_methods.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="fa fa-shipping-fast"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">طرق الشحن</span>
                        {{--                        <span class="info-box-number">None</span> --}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('clearance_attachment.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="fa fa-file"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">مرفقات التخليص</span>
                        {{--                        <span class="info-box-number">None</span> --}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('estimation_cost_element.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="fa fa-list"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">عناصر تقدير التكلفة</span>
                        {{--                        <span class="info-box-number">None</span> --}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('order_status.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="fa fa-stamp"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">حالة الطلبيات</span>
                        {{--                        <span class="info-box-number">None</span> --}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('setting.system_setting.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="fa fa-cog"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">اعدادات النظام</span>
                        {{--                        <span class="info-box-number">None</span> --}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('setting.user_category.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="fa fa-list"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">مجالات الاختصاص</span>
                        {{--                        <span class="info-box-number">None</span> --}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('criteria.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="fa fa-list"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">معايير التقييم</span>
                        {{--                        <span class="info-box-number">None</span> --}}
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection()
