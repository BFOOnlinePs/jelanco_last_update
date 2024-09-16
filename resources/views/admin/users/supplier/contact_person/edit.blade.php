@extends('home')
@section('title')
    تعديل جهة اتصال
@endsection
@section('header_title')
    تعديل جهة اتصال
@endsection
@section('header_link')
    الموردين
@endsection
@section('header_title_link')
    تعديل جهة اتصال
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.supplier.contact_person_update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $data->id }}" name="id">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="">الاسم</label>
                            <input name="contact_name" class="form-control" value="{{ $data->contact_name }}" type="text" placeholder="يرجى كتابة الاسم">
                        </div>
                        <div class="form-group">
                            <label for="">رقم الهاتف</label>
                            <input name="mobile_number" class="form-control" value="{{ $data->mobile_number }}" type="text" placeholder="يرجى كتابة رقم الهاتف">
                        </div>
                        <div class="form-group">
                            <label for="">الايميل</label>
                            <input name="email" class="form-control" value="{{ $data->email }}" type="text" placeholder="يرجى كتابة البريد الالكتروني">
                        </div>
                        <div class="form-group">
                            <label for="">رقم الوتس اب</label>
                            <input name="whats_app_number" class="form-control" value="{{ $data->whats_app_number }}" type="text" placeholder="يرجى كتابة رقم الوتس اب">
                        </div>
                        <div class="form-group">
                            <label for="">رقم wechat</label>
                            <input name="wechat_number" class="form-control" value="{{ $data->wechat_number }}" type="text" placeholder="يرجى كتابة رقم الوي شات">
                        </div>
                        <div class="form-group">
                            <label for="">العنوان</label>
                            <textarea  class="form-control" placeholder="يرجى كتابة العنوان" name="address" id="" cols="30" rows="3"{{ $data->address }}></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <span class="text-center" for="">الصورة</span>
                        <br>
                        <img style="width: 200px" src="{{ asset('storage/user_photo/'.$data->photo) }}" class="img-thumbnail" alt="">
                        <p class="mt-3">رفع صورة</p>
                        <input name="photo" type="file" class="form-control">
                    </div>
                    <button class="btn btn-success" type="submit">تعديل</button>
                </div>
            </form>

        </div>

    </div>

@endsection

