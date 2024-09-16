@extends('home')
@section('title')
    الملف الشخصي
@endsection
@section('header_title')
    الملف الشخصي
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    الملف الشخصي
@endsection
@section('content')
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">الملف الشخصي</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">الاسم</label>
                    <span class="form-control">{{ $data->name }}</span>
                </div>
                <div class="form-group">
                    <label for="">الايميل</label>
                    <span class="form-control">{{ $data->email }}</span>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">رقم الهاتف الاول</label>
                        <span class="form-control">{{ $data->user_phone1 }}</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">رقم الهاتف الثاني</label>
                        <span class="form-control">{{ $data->user_phone2 }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">حالة المستخدم</label>
                    @if($data->user_status == 1)
                        <span class="form-control text-success">فعال</span>
                    @else
                        <span class="form-control text-danger">غير فعال</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">صورة المستخدم</label>
                    <br>
                    <img src="{{ asset('storage/user_photo/'.$data->user_photo) }}" width="100" height="100" alt="" class="img-thumbnail">
                </div>
            </div>
        </div>
@endsection()
