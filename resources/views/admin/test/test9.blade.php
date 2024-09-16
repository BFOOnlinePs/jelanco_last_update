@extends('home')
@section('title')
    طلبات الشراء
@endsection
@section('header_title')
    طلبات الشراء
@endsection
@section('header_link')
    ادارة طلبات الشراء
@endsection
@section('header_title_link')
    طلبات الشراء
@endsection
@section('content')
    <div class="container">
        {{--        <a href="{{ route('users.add') }}" class="btn btn-primary mb-2">اضافة مستخدم</a>--}}
        <div class="card">
            <div class="card-header" >
                <h5 class=""><span class="text-danger">طلب شراء رقم 23312421</span> - <span class="text-primary">انس المحتسب</span> - <span>15-06-2023</span></h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a class="btn btn-warning d-block m-2">تصاريح</a>
                        <a class="btn btn-warning d-block m-2">المستندات</a>
                        <a class="btn btn-warning d-block m-2">الفواتير</a>
                        <a class="btn btn-warning d-block m-2">التامين</a>
                        <a class="btn btn-warning d-block m-2">حالة الطلبية</a>
                        <a class="btn btn-warning d-block m-2">طريقة الدفع</a>
                        <a class="btn btn-warning d-block m-2">الشحن</a>
                        <a class="btn btn-warning d-block m-2">التخليص</a>
                        <a class="btn btn-warning d-block m-2">الاتفاقيات</a>
{{--                        <a class="btn btn-warning d-block m-2">حالة الطلبات</a>--}}
                    </div>
                    <div class="col border border-black ml-3">
                        <div class="border-top-0">
                            <div class="m-2">
                                <h4 class="text-center">قائمة التخليص</h4>
                                <a href="" class="mb-2 btn btn-sm btn-primary">اضافة تخليص</a>
                                <div class="row">
                                    <div class="col">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>رقم التخليص</th>
                                                <th>اسم التخليص</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>التخليص رقم 1</td>
                                                <td>
                                                    <a href="" class="btn btn-primary btn-sm">تفاصيل</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>التخليص رقم 2</td>
                                                <td>
                                                    <a href="" class="btn btn-primary btn-sm">تفاصيل</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>التخليص رقم 3</td>
                                                <td>
                                                    <a href="" class="btn btn-primary btn-sm">تفاصيل</a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
{{--                                    <div class="col bg-primary">--}}
{{--                                        <div class="m-3">--}}
{{--                                            <h4>اضافة</h4>--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="">اسم التخليص</label>--}}
{{--                                                <input class="form-control" type="text" value="">--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="">نبذة عن التخليص</label>--}}
{{--                                                <input class="form-control" type="text" value="">--}}
{{--                                            </div>--}}
{{--                                            <button class="btn btn-success">حفظ</button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="height: 25px">

    </div>


@endsection
