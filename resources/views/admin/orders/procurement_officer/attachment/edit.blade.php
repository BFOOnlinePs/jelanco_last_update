@extends('home')
@section('title')
    تعديل مرفق
@endsection
@section('header_title')
    تعديل مرفق
@endsection
@section('header_link')
    مرفقات
@endsection
@section('header_title_link')
    تعديل مرفق
@endsection
@section('style')

@endsection
@section('content')
    {{--    @include('admin.orders.progreesbar')--}}
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">المرفقات</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">الوصف</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">الوصف</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()

@section('script')

@endsection
