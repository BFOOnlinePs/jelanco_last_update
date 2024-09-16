@extends('home')
@section('title')
    المستخدمين
@endsection
@section('header_title')
    المستخدمين
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    المستخدمين
@endsection
@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('users.procurement_officer.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">موظف المشتريات</span>
{{--                        <span class="info-box-number">None</span>--}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('users.storekeeper.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">أمين المستودع</span>
{{--                        <span class="info-box-number">Small</span>--}}
                    </div>

                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('users.secretarial.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">سكرتيريا</span>
{{--                        <span class="info-box-number">Regular</span>--}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('users.supplier.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">الموردين</span>
{{--                        <span class="info-box-number">Large</span>--}}
                    </div>
                </div>

            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('users.delivery_company.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">شركات الشحن</span>
{{--                        <span class="info-box-number">None</span>--}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('users.clearance_companies.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">شركات التخليص</span>
{{--                        <span class="info-box-number">None</span>--}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('users.local_carriers.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">شركات النقل المحلي</span>
{{--                        <span class="info-box-number">None</span>--}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('users.insurance_companies.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">شركات التأمين</span>
{{--                        <span class="info-box-number">None</span>--}}
                    </div>
                </div>
            </a>
        </div>
        {{--    <div class="col-md-3 col-sm-6 col-12">--}}
        {{--        <div class="info-box shadow-none">--}}
        {{--            <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>--}}
        {{--            <div class="info-box-content">--}}
        {{--                <span class="info-box-text">حالة الطلبات</span>--}}
        {{--                <span class="info-box-number">None</span>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--    </div>--}}
    </div>
@endsection
