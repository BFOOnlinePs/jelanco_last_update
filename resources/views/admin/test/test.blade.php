@extends('home')
@section('title')
    الموردين
@endsection
@section('header_title')
    الموردين
@endsection
@section('header_link')
    ادارة الموردين
@endsection
@section('header_title_link')
    الموردين
@endsection
@section('content')
    <div class="container">
        {{--        <a href="{{ route('users.add') }}" class="btn btn-primary mb-2">اضافة مستخدم</a>--}}
        <div class="card">
            <div class="card-header" >
                <h5 class="text-center">قائمة الموردين</h5>
            </div>

            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                    </div>
                    <form action="" method="post">
                        @csrf
                        <a href="" class="btn btn-primary mb-3">اضافة مورد جديد</a>
                        <div class="row">
{{--                            <div class="col-sm-3 bg-gradient-warning p-4">--}}
{{--                                <h6 class="text-center">اضافة مورد جديد</h6>--}}
{{--                                <hr>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">اسم الزبون</label>--}}
{{--                                    <input value="{{ old('name') }}" name="name" type="text" class="form-control">--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">البريد الالكتروني</label>--}}
{{--                                    <input value="{{ old('email') }}" name="email" type="text" class="form-control">--}}

{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">رقم الهاتف</label>--}}
{{--                                    <input value="{{ old('user_phone') }}" name="user_phone" type="text" class="form-control">--}}

{{--                                </div>--}}
{{--                                <div class="form-group" align="left">--}}
{{--                                    <button type="submit" class="btn btn-sm btn-secondary">اضافة مورد جديد</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col">
                                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
                                       aria-describedby="example1_info">
                                    <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">
                                            #
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending">الاسم
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                            البريد الالكتروني
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Engine version: activate to sort column ascending">
                                            حالة الحساب
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="CSS grade: activate to sort column ascending">العمليات
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Mohamad Maraqa</td>
                                            <td>maraqamohamad@gmail.com</td>
                                            <td>فعال</td>
                                            <td>
                                                <a href="" class="btn btn-warning btn-sm">تفاصيل</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Anas Mohtaseb</td>
                                            <td>anasmohtaseb@gmail.com</td>
                                            <td>فعال</td>
                                            <td>
                                                <a href="" class="btn btn-warning btn-sm">تفاصيل</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Bashar Bakri</td>
                                            <td>basharbakri@gmail.com</td>
                                            <td>غير فعال</td>
                                            <td>
                                                <a href="" class="btn btn-warning btn-sm">تفاصيل</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Hammam Najjar</td>
                                            <td>hammamnajjar@gmail.com</td>
                                            <td>فعال</td>
                                            <td>
                                                <a href="" class="btn btn-warning btn-sm">تفاصيل</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div style="height: 25px">

    </div>


@endsection
