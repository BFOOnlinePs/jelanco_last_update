@extends('home')
@section('title')
    الموردين
@endsection
@section('header_title')
    الموردين
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    الموردين
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/main.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <style>
        #custom-content-below-calender {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: stretch;
        }

        #calendar {
            flex: 1;
        }

        .pagination_style{
            font-size: 12px;
        }

    </style>
@endsection
@section('content')

    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">
        {{--        <div class="card-header text-center">--}}
        {{--            <h5 class="text-bold">تفاصيل المورد</h5>--}}
        {{--        </div>--}}
        <div class="card-body">

            <style>
                .active {
                    color: black !important;
                }

                .nav-link {
                    text-decoration: none;
                }
            </style>


            {{--            <form action="{{ route('users.supplier.create') }}" method="post" enctype="multipart/form-data">--}}
            <div class="row">
                <div class="modal fade" id="modal-default-1">
                    <div class="modal-dialog">
                        <form action="{{ route('users.supplier.createProductSupplier') }}" method="post">
                            @csrf
                            <input type="hidden" value="{{ $data->id }}" name="user_id">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">اضافة صنف</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">البحث عن صنف</label>
                                        <select class="form-control select2bs4" name="product_id" id="">
                                            @foreach($products as $key)
                                                <option value="{{ $key->id }}">{{ $key->barcode }}
                                                    - {{ $key->product_name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="modal fade" id="modal-lg-add-bank">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">اضافة بنك</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('users.supplier.create_bank_supplier') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $data->id }}" name="supplier_id">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">اسم البنك</label>
                                                <input name="user_bank_name" class="form-control" type="text"
                                                       placeholder="اكتب اسم البنك" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">رقم حساب البنك</label>
                                                <input name="account_number" class="form-control" type="text"
                                                       placeholder="رقم حساب البنك" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">الشخص الذي يمكن الاتصال به
                                                </label>
                                                <input name="contact_person" class="form-control" type="text"
                                                       placeholder="الشخص الذي يمكن الاتصال به">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">مالك الحساب</label>
                                                <input type="text" name="account_owner" class="form-control"
                                                       placeholder="مالك الحساب">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">swift code</label>
                                                <input type="text" name="user_swift_code" class="form-control"
                                                       placeholder="swift code">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">iban number</label>
                                                <input type="text" name="user_iban_number" class="form-control"
                                                       placeholder="swift code">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">اسم المستفيد</label>
                                                <input type="text" name="beneficiary_name" class="form-control"
                                                       placeholder="swift code">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">معلومات الاتصال</label>
                                                <input class="form-control" name="contact_mobile" type="text"
                                                       placeholder="معلومات الاتصال">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">العنوان</label>
                                                <textarea class="form-control" name="user_bank_address" id=""
                                                          cols="30" rows="3" placeholder="العنوان"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">ملاحظات</label>
                                                <textarea class="form-control" name="notes" id="" cols="30"
                                                          rows="3" placeholder="ملاحظات"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card-body">

                        <h3 class="pb-3">{{ $data->name }}</h3>
                        <ul class="nav nav-tabs alert-info text-white" style="" id="custom-content-below-tab"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(session('tab_id') == 1) active @endif text-white"
                                   id="custom-content-below-home-tab"
                                   data-toggle="pill"
                                   href="#custom-content-below-home" role="tab"
                                   aria-controls="custom-content-below-home"
                                   aria-selected="@if(\Illuminate\Support\Facades\Session::has('tab_id')) @if(session('tab_id') == 1) true @else false @endif @endif">المعلومات
                                    العامة</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white @if(session('tab_id') == 2) active @endif"
                                   id="custom-content-below-profile-tab" data-toggle="pill"
                                   href="#custom-content-below-profile" role="tab"
                                   aria-controls="custom-content-below-profile" aria-selected="false">معلومات البنك</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(session('tab_id') == 3) active @endif text-white"
                                   id="custom-content-below-messages-tab" data-toggle="pill"
                                   href="#custom-content-below-messages" role="tab"
                                   aria-controls="custom-content-below-messages"
                                   aria-selected="@if(\Illuminate\Support\Facades\Session::has('tab_id')) @if(session('tab_id') == 2) true @else false @endif @endif">جهات
                                    الاتصال</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white @if(session('tab_id') == 4) active @endif"
                                   id="custom-content-below-orders-tab" data-toggle="pill"
                                   href="#custom-content-below-orders" role="tab"
                                   aria-controls="custom-content-below-orders" aria-selected="false">الطلبيات</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white @if(session('tab_id') == 5) active @endif"
                                   id="custom-content-below-calender-tab" data-toggle="pill"
                                   href="#custom-content-below-calender" role="tab"
                                   aria-controls="custom-content-below-calender" aria-selected="false">تقويم</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-white @if(session('tab_id') == 7) active @endif"
                                   id="custom-content-below-follow_up_records-tab" data-toggle="pill"
                                   href="#custom-content-below-follow_up_records" role="tab"
                                   aria-controls="custom-content-below-follow_up_records" aria-selected="false">سجل
                                    المتابعة</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white @if(session('tab_id') == 8) active @endif"
                                   id="custom-content-below-settings-tab" data-toggle="pill"
                                   href="#custom-content-below-settings" role="tab"
                                   aria-controls="custom-content-below-settings"
                                   aria-selected="@if(session('tab_id') == 8) true @else false @endif">الأصناف</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white @if(session('tab_id') == 9) active @endif"
                                   id="supplier_notes-tab" data-toggle="pill"
                                   href="#supplier_notes" role="tab"
                                   aria-controls="supplier_notes"
                                   aria-selected="@if(session('tab_id') == 9) true @else false @endif">ملاحظات المورد</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="custom-content-below-tabContent">
                            <div
                                class="tab-pane fade @if(session('tab_id') == null) show active @endif  @if(session('tab_id') == 1) active show @endif"
                                id="custom-content-below-home" role="tabpanel"
                                aria-labelledby="custom-content-below-home-tab">
                                <div class="p-2">
                                    <div class="row">
                                        <div class="col-md-8 p-5">
                                            <div class="form-group">
                                                <label for="">الاسم :</label>
                                                <span class="form-control">{{ $data->name }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="">الايميل :</label>
                                                <span class="form-control">{{ $data->email }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="">رقم الهاتف الاول :</label>
                                                <span class="form-control">{{ $data->user_phone1 }}</span>
                                            </div>
                                            <div class="form-group">
                                                @if($data->user_phone2 == '')
                                                    <label for="">رقم الهاتف الثاني :</label>
                                                    <span class="form-control">لا يوجد</span>
                                                @else
                                                    <label for="">رقم الهاتف الثاني :</label>
                                                    <span class="form-control">{{ $data->user_phone2 }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="">حالة المستخدم</label>
                                                @if($data->status == 1)
                                                    <span class="form-control text-success">فعال</span>
                                                @elseif($data->status == 0)
                                                    <span class="text-danger form-control">غير فعال</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="">ملاحظات : </label>
                                                <textarea readonly class="form-control" name="" id="" cols="30"
                                                          rows="3">{{ $data->user_notes }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">الموقع الالكتروني : <span><a
                                                            href="">{{ $data->user_website }}</a></span></label>
                                            </div>
                                            <div class="form-group">
                                                <label for="">العنوان :</label>
                                                <textarea readonly class="form-control" name="" id="" cols="30"
                                                          rows="3">{{ $data->user_address }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">مجال العمل :</label>
                                                <span class="form-control"></span>
                                            </div>


                                        </div>
                                        <div class="col-md-4 pt-5 text-center">
                                            <div class="form-group text-center">
                                                <img width="150"
                                                     src="{{ asset('storage/user_photo/'.$data->user_photo) }}"
                                                     alt="">
                                            </div>
                                            <div>
                                                <h4 class="text-center">{{ $data->name }}</h4>
                                                <hr>
                                                <p>يحتوي هذا القسم على المعلومات الاساسية للمورد</p>
                                                <a href="{{ route('users.supplier.edit',['id'=>$data->id]) }}"
                                                   class="btn btn-info">تعديل بيانات المورد</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(session('tab_id') == 2) active show @endif"
                                 id="custom-content-below-profile" role="tabpanel"
                                 aria-labelledby="custom-content-below-profile-tab">
                                <div class="row m-3 pt-3 table-bordered">
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-info mt-2" data-toggle="modal"
                                                data-target="#modal-lg-add-bank">
                                            <span class="fa fa-plus text-white"
                                            ></span>
                                            اضافة بنك
                                        </button>
                                    </div>
                                    <div class="col-md-8">
                                        <h4>معلومات البنك</h4>
                                        <p>يحتوي هذا القسم على جميع معلومات البنك الذي يتم التعامل معه بواسطة هذا
                                            المورد</p>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa-solid fa-building-columns text-info"
                                           style="font-size: 50px"></i>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 pt-3">
                                        <div class="table-responsive">
                                            <table style="width: 100%" class="table-sm table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>اسم المستفيد</th>
                                                    <th>رقم حساب البنك</th>
                                                    <th>اسم البنك</th>
                                                    <th>عنوان البنك</th>
                                                    <th>swift code</th>
                                                    <th>iban number</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($supplier_banks as $suppler_bank)
                                                    <tr id="bank_supplier_{{$suppler_bank->id}}">
                                                        <td>{{ $suppler_bank->beneficiary_name }}</td>
                                                        <td>{{ $suppler_bank->account_number }}</td>
                                                        <td>{{ $suppler_bank->user_bank_name }}</td>
                                                        <td>{{ $suppler_bank->user_bank_address }}</td>
                                                        <td>{{ $suppler_bank->user_swift_code }}</td>
                                                        <td>{{ $suppler_bank->user_iban_number }}</td>
                                                        <td>
                                                            <a href="{{ route('users.supplier.edit_bank_supplier',['id'=>$suppler_bank->id]) }}"
                                                               class="btn btn-success btn-sm"><span
                                                                    class="fa fa-edit pt-1"></span></a>
                                                            <button class="btn btn-danger btn-sm"
                                                                    onclick="delete_bank_supplier({{ $suppler_bank->id }})">
                                                                <span class="fa fa-trash pt-1"></span></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        {{--                                        <div class="form-group">--}}
                                        {{--                                            <label for="">اسم المستفيد :</label>--}}
                                        {{--                                            <input class="form-control" type="text" name="account_owner"--}}
                                        {{--                                                   placeholder="اسم جهة الحساب">--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="form-group">--}}
                                        {{--                                            <label>رقم حساب البنك :</label>--}}
                                        {{--                                            <span--}}
                                        {{--                                                class="form-control">{{ $data->user_account_number }}</span>--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="form-group">--}}
                                        {{--                                            <label>اسم البنك :</label>--}}
                                        {{--                                            <span--}}
                                        {{--                                                class="form-control">{{ $data->user_bank_name }}</span>--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="form-group">--}}
                                        {{--                                            <label>عنوان البنك :</label>--}}
                                        {{--                                            <textarea disabled class="form-control" name="" id=""--}}
                                        {{--                                                      cols="30"--}}
                                        {{--                                                      rows="3">{{ $data->user_bank_address }}</textarea>--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="form-group">--}}
                                        {{--                                            <label>Swift code :</label>--}}
                                        {{--                                            <span--}}
                                        {{--                                                class="form-control">{{ $data->user_swift_code }}</span>--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="form-group">--}}
                                        {{--                                            <label>IBAN Number :</label>--}}
                                        {{--                                            <span--}}
                                        {{--                                                class="form-control">{{ $data->user_iban_number }}</span>--}}
                                        {{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                            <div
                                class="tab-pane fade @if(\Illuminate\Support\Facades\Session::has('tab_id')) @if(session('tab_id') == 3) show active @endif @endif"
                                id="custom-content-below-messages" role="tabpanel"
                                aria-labelledby="custom-content-below-messages-tab">
                                <div class="row m-3 pt-3 table-bordered">
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#modal-default">
                                            <span class="fa fa-plus text-white"
                                            ></span>
                                            اضافة جديد
                                        </button>
                                    </div>
                                    <div class="col-md-8">
                                        <h4>معلومات جهات الاتصال</h4>
                                        <p>يحتوي هذا القسم على معلومات جهات الاتصال التي يتم التواصل من خلالها مع
                                            هذا المورد</p>
                                    </div>
                                    <div class="col-md-2">
                                        <i class="fa-solid fa-address-card text-info" style="font-size: 50px"></i>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 pt-3">
                                        <table style="font-size: 14px;border: solid 1px black;width: 100%"
                                               id="contact_person_table"
                                               class="table-sm table-hover table-bordered text-center">
                                            <thead>
                                            <tr>
                                                <th>الصورة</th>
                                                <th>الاسم</th>
                                                <th>الهاتف</th>
                                                <th>الايميل</th>
                                                <th>الوتس اب</th>
                                                <th>الوي شات</th>
                                                <th>العنوان</th>
                                                <th>العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($company_contact_person as $key)
                                                <tr id="delete_{{$key->id}}">
                                                    <td><img style="width: 30px;height: 30px" class="p-1"
                                                             src="{{ asset('storage/user_photo/avatar.png') }}" alt="">
                                                    </td>
                                                    <td>{{ $key->contact_name }}</td>
                                                    <td>{{ $key->mobile_number }}</td>
                                                    <td>{{ $key->email }}</td>
                                                    <td>{{ $key->whats_app_number }}</td>
                                                    <td>{{ $key->wechat_number }}</td>
                                                    <td>{{ $key->address }}</td>
                                                    <td>
                                                        <a class="btn btn-success btn-sm"
                                                           href="{{ route('users.supplier.contact_person_edit',['id'=>$key->id]) }}"><span
                                                                class="fa fa-edit pt-1"></span></a>
                                                        <button onclick="deleteMessage({{ $key->id }})"
                                                                class="btn btn-sm btn-danger"><span
                                                                class="fa fa-trash pt-1"></span>
                                                        </button>
                                                    </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="modal fade" id="modal-default">
                                        <div class="modal-dialog">
                                            <form action="{{ route('company_contact_person.supplier.create') }}"
                                                  method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="text" hidden name="company_id"
                                                       value="{{ $data->id }}">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">اضافة جهة تواصل جديدة</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">الاسم</label>
                                                                    <input name="contact_name" class="form-control"
                                                                           type="text"
                                                                           placeholder="الاسم">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">رقم الهاتف</label>
                                                                    <input name="mobile_number" class="form-control"
                                                                           type="text"
                                                                           placeholder="رقم الهاتف">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">البريد الالكتروني</label>
                                                                    <input name="email" class="form-control" type="text"
                                                                           placeholder="البريد الالكتروني">
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">رقم WeChat</label>
                                                                    <input name="wechat_number" class="form-control"
                                                                           type="text"
                                                                           placeholder="رقم وي شات">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">رقم WhatsApp</label>
                                                                    <input name="whats_app_number" class="form-control"
                                                                           type="text"
                                                                           placeholder="رقم الواتس اب">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">العنوان</label>
                                                                    <textarea class="form-control" name="address" id=""
                                                                              cols="30"
                                                                              rows="2" placeholder="العنوان"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">الصورة</label>
                                                            <div class="custom-file">
                                                                <input name="photo" type="file"
                                                                       class="custom-file-input"
                                                                       id="customFile">
                                                                <label class="custom-file-label"
                                                                       for="customFile">تحميل
                                                                    صورة</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">اغلاق
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">حفظ
                                                        </button>
                                                    </div>

                                                </div>
                                            </form>

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane fade @if(session('tab_id') == 8) active show @endif"
                                 id="custom-content-below-settings" role="tabpanel"
                                 aria-labelledby="custom-content-below-settings-tab">
                                <div class="p-2">
                                    <div class="card card-info">
                                        <div class="card-header text-center">
                                            <span>أصناف المورد</span>
                                        </div>

                                        <div class="card-body p-4">
                                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                                                <div class="row">
                                                    <div class="col-md-5" style="overflow: hidden">
                                                        <div class="">
                                                            <div class="form-group">
                                                                <div class="alert alert-info text-center">
                                                                    <h5>تعريف أصناف المورد</h5>
                                                                    <hr>
                                                                    <p>يمكن من خلال النموذج التالي تحديد الأصناف التي يعمل بها هذا المورد</p>
                                                                    <input onkeyup="product_search_ajax()" placeholder="البحث عن صنف" class="form-control" id="search_product" name="search_product" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form
                                                            action="{{ route('users.supplier.createProductSupplier') }}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" value="{{ $data->id }}" name="user_id">
                                                            <div>
                                                                <div id="product_search">

                                                                </div>
                                                                {{-- <div class="form-group">
                                                                    <label for="">البحث عن صنف</label>
                                                                    <select required multiple="multiple" class="form-control select2bs4"
                                                                            name="product_id[]" id="">
                                                                        @foreach($products as $key)
                                                                            <option
                                                                                value="{{ $key->id }}">{{ $key->barcode }}
                                                                                - {{ $key->product_name_ar }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div> --}}
                                                            </div>
                                                            {{-- <button type="submit" class="btn btn-success">حفظ</button> --}}
                                                        </form>
                                                    </div>
                                                    <div class="col-sm-7">
                                                        <div id="product_list">

                                                        </div>
                                                        {{-- <table id="example1"
                                                               class="table table-bordered table-striped dataTable dtr-inline"
                                                               aria-describedby="example1_info">
                                                            <thead>
                                                            <tr>
                                                                <th>المنتج</th>
                                                                <th>الصنف باللغة الانجليزية</th>
                                                                <th>
                                                                    العمليات
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($product_supplier as $key)
                                                                <tr>
                                                                    <td>{{ $key['product']->product_name_ar ?? '' }}</td>
                                                                    <td>
                                                                        <input
                                                                            onchange="edit_product_ajax({{ $key['product']->id }})"
                                                                            id="product_name_en_{{ $key['product']->id }}"
                                                                            class="form-control" type="text"
                                                                            value="{{ $key['product']->product_name_en }}">
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('users.supplier.delete_product_supplier',['id'=>$key->id]) }}"
                                                                           onclick="return confirm('هل انت متاكد من عملية الحذف ؟')"
                                                                           class="btn btn-danger btn-sm"><span
                                                                                class="fa fa-trash"></span></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(session('tab_id') == 7) active show @endif"
                                 id="custom-content-below-follow_up_records" role="tabpanel"
                                 aria-labelledby="custom-content-below-follow_up_records-tab">
                                <div class="p-2">
                                    <div class="card card-info">
                                        <div class="card-header text-center">
                                            <span>سجل المتابعة</span>
                                        </div>

                                        <div class="card-body p-4">
                                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                                <button type="button" class="btn btn-dark btn-sm mb-2"
                                                        data-toggle="modal"
                                                        data-target="#modal-users_follow_up">
                                                    اضافة سجل متابعة
                                                </button>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table id="example1"
                                                               class="table table-bordered table-striped dataTable dtr-inline"
                                                               aria-describedby="example1_info">
{{--                                                            <thead>--}}
{{--                                                            <tr>--}}
{{--                                                                <th>المنتج</th>--}}
{{--                                                                <th>--}}
{{--                                                                    العمليات--}}
{{--                                                                </th>--}}
{{--                                                            </tr>--}}
{{--                                                            </thead>--}}
                                                            <tbody>
                                                            @foreach($users_follow_up_records as $key)
                                                                <tr>
                                                                    <td>{{ $key->note_text }}</td>
                                                                    <td>
                                                                        @if(empty($key->attachment))
                                                                            لا يوجد مرفقات
                                                                        @else
                                                                            <a type="text"
                                                                               href="{{ asset('storage/attachment/'.$key->attachment) }}"
                                                                               download="attachment"
                                                                               class="btn btn-primary btn-sm"><span
                                                                                    class="fa fa-download"></span></a>
                                                                            <button
                                                                                onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->attachment) }}',null)"
                                                                                href="" class="btn btn-success btn-sm"
                                                                                data-toggle="modal"
                                                                                data-target="#modal-lg-view_attachment"><span
                                                                                    class="fa fa-search"></span>
                                                                            </button>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{ \Carbon\Carbon::parse($key->insert_date)->toDateString() }}
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('users.supplier.edit_for_supplier',['id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                                                        <a href="{{ route('users.supplier.delete_for_supplier',['id'=>$key->id]) }}"
                                                                           onclick="return confirm('هل انت متاكد من عملية الحذف ؟')"
                                                                           class="btn btn-danger btn-sm"><span
                                                                                class="fa fa-trash"></span></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(session('tab_id') == 9) active show @endif"
                                 id="supplier_notes" role="tabpanel"
                                 aria-labelledby="supplier_notes-tab">
                                <div class="p-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <button onclick="open_supplier_notes_modal()" class="btn btn-dark btn-sm">اضافة ملاحظة للمورد</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <table class="table table-sm">
                                                        <thead>
                                                        <tr>
                                                            <th>نص الملاحظة</th>
                                                            <th>الملف</th>
                                                            <th>العمليات</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if($supplier_notes->isEmpty())
                                                            <tr>
                                                                <td colspan="3" class="text-center">لا توجد ملاحظات</td>
                                                            </tr>
                                                        @else
                                                            @foreach($supplier_notes as $key)
                                                                <tr>
                                                                    <td>{{ $key->text }}</td>
                                                                    <td>
                                                                        @if(empty($key->file))
                                                                            لا يوجد ملفات
                                                                        @else
                                                                            <a type="text"
                                                                               href="{{ asset('storage/supplier_notes/'.$key->file) }}"
                                                                               download="{{ $key->file }}" class="btn btn-primary btn-sm"><span
                                                                                    class="fa fa-download"></span></a>
                                                                            <button
                                                                                onclick="viewAttachment({{ $key->id }},'{{ asset('storage/supplier_notes/'.$key->file) }}',null)"
                                                                                href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                                                data-target="#modal-lg-view_attachment"><span
                                                                                    class="fa fa-search"></span></button>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-sm btn-success" onclick="open_edit_supplier_notes_modal({{ $key }})"><span class="fa fa-edit"></span></button>
                                                                        <a class="btn btn-sm btn-danger" href="{{ route('users.supplier.supplier_notes.delete',['id'=>$key->id]) }}" onclick="return confirm('هل تريد حذف البيانات ؟')"><span class="fa fa-trash"></span></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-orders" role="tabpanel"
                                 aria-labelledby="custom-content-below-orders-tab">
                                <div class="p-2">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                            <tr>
                                                <th>الرقم المرجعي للطلبية</th>
                                                <th>تاريخ الارسال</th>
                                                <th>حالة الطلبية</th>
                                                <th>العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order_supplier as $key)
                                                <tr>
                                                    <td>{{ $key->reference_number }}</td>
                                                    <td>{{ $key->created_at }}</td>
                                                    <td>
                                                        {{--                                                        @if($key->order_status == 1)--}}
                                                        {{--                                                            <span>فعالة</span>--}}
                                                        {{--                                                        @else--}}
                                                        {{--                                                            <span>غير فعالة</span>--}}
                                                        {{--                                                        @endif--}}
                                                        <span>تم ارسالها الى المشتريات</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('procurement_officer.orders.product.index',['order_id'=>$key->order_id]) }}"
                                                           class="btn btn-dark btn-sm">عرض الطلبية</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade @if(session('tab_id') == 5) active show @endif"
                                 id="custom-content-below-calender" role="tabpanel"
                                 aria-labelledby="custom-content-below-calender-tab">
                                <div id='calendar'></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-users_follow_up">
            <div class="modal-dialog modal-xl">
                <form action="{{ route('users.supplier.create_for_supplier') }}"
                      method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="text" hidden name="supplier_id"
                           value="{{ $data->id }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">اضافة سجل متابعة</h4>
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">النص</label>
                                        <textarea name="note_text" class="form-control" id="" cols="30"
                                                  rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">الملف</label>
                                        <div class="custom-file">
                                            <input name="attachment" type="file"
                                                   class="custom-file-input"
                                                   id="customFile">
                                            <label class="custom-file-label"
                                                   for="customFile">تحميل الملف</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">اضافة تنبيه</label>
                                        <input name="notification_date" type="date" class="form-control"
                                               placeholder="نبهني بتاريخ">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger"
                                    data-dismiss="modal">اغلاق
                            </button>
                            <button type="submit" class="btn btn-primary">حفظ
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('admin.users.supplier.modals.add_supplier_notes_modal')
    @include('admin.users.supplier.modals.edit_supplier_notes_modal')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('assets/calendar/js/adminlte.io_themes_v3_plugins_jquery_jquery.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/fullcalendar/main.js') }}"></script>

    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src='{{ asset('assets/calendar/js/cdn.jsdelivr.net_npm_fullcalendar@6.1.8_index.global.min.js') }}'></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script>
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            product_search_ajax(page);
        });

        function add_contact_person() {
            var contact_person_table = document.getElementById('contact_person_table');
            var count = {{ \App\Models\CompanyContactPersonModel::count() }};
            if (contact_person_table.rows.length == count + 1) {
                var new_row = contact_person_table.insertRow();
                var cell1 = new_row.insertCell();
                var cell2 = new_row.insertCell();
                var cell3 = new_row.insertCell();
                var cell4 = new_row.insertCell();
                cell1.innerText = '2';
                cell2.innerText = 'test2';
                cell3.innerHTML = '<button class="btn btn-sm btn-dark">تفاصيل</button>';
                cell4.innerHTML = '<button class="btn btn-sm btn-danger">X</button>';
            } else {
                alert('يرجى تعبئة الحقل الفارغ')
            }
            console.log(contact_person_table.rows.length);
            // console.log(count);

        }

        function deleteMessage(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            var confirmationMessage = "هل انت متاكد انك تريد حذف البيانات ؟";
            var userConfirmed = window.confirm(confirmationMessage);
            if (userConfirmed) {
                $.ajax({
                    url: '{{ url('company_contact_person/delete') }}' + '/' + id,
                    method: 'get',
                    headers: headers,
                    success: function (data) {
                        document.getElementById('delete_' + id).remove();
                        toastr.success('تم حذف البيانات بنجاح')
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            }
        }

        function delete_bank_supplier(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            var confirmationMessage = "هل انت متاكد انك تريد حذف البيانات ؟";
            var userConfirmed = window.confirm(confirmationMessage);
            if (userConfirmed) {
                var deleteBankSupplierUrl = '{{ route('users.supplier.delete_bank_supplier', ['id' => 'bank_supplier_id_placeholder']) }}';
                var url = deleteBankSupplierUrl.replace('bank_supplier_id_placeholder', id);
                $.ajax({
                    url: url,
                    method: 'get',
                    headers: headers,
                    success: function (data) {
                        document.getElementById('bank_supplier_' + id).remove();
                        toastr.success('تم حذف البيانات بنجاح')
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            }
        }

        function edit_product_ajax(id) {
            {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '{{ route('product.edit_product_ajax') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'product_id': id,
                        'product_name_en': document.getElementById('product_name_en_' + id).value,
                    },
                    success: function (data) {
                        console.log(data);
                        toastr.success('تم تعديل الاسم بنجاح')
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }

                });
            }
        }
        function product_search_ajax(page = 1) {
            {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                document.getElementById('product_search').innerHTML = '<div class="text-center"><i class="fas fa-2x fa-sync fa-spin"></i></div>';
                $.ajax({
                    url: '{{ route("users.supplier.product_search_ajax") }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'search_product': document.getElementById('search_product').value,
                        'user_id': {{ $data->id }},
                        'page': page
                    },
                    success: function (data) {
                        console.log(data);
                        $('#product_search').html(data.data)
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }

                });
            }
        }

        function product_list_ajax() {
            {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '{{ route("users.supplier.product_list_ajax") }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'user_id': {{ $data->id }},
                    },
                    success: function (data) {
                        $('#product_list').html(data.data)
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }

                });
            }
        }

        function add_to_product_supplier_ajax(product_id){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                document.getElementById('product_list').innerHTML = '<div class="text-center"><i class="fas fa-2x fa-sync fa-spin"></i></div>';
                $.ajax({
                    url: '{{ route("users.supplier.add_to_product_supplier_ajax") }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'user_id': {{ $data->id }},
                        'product_id': product_id,
                        'checked': document.getElementById('checkbox_product_'+product_id).checked,
                    },
                    success: function (data) {
                        console.log(data);
                        $('#product_list').html(data.data);
                        if(data.status == 'save'){
                            toastr.success(data.message);
                        }
                        else{
                            toastr.error(data.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }

                });
        }

        window.onload = function(){
            product_search_ajax();
            product_list_ajax();
        }

        function open_supplier_notes_modal() {
            $('#add_supplier_notes_modal').modal('show')
        }

        function open_edit_supplier_notes_modal(data) {
            $('#edit_supplier_notes_modal').modal('show')
            $('#supplier_notes_id').val(data.id);
            $('#supplier_notes_text').val(data.text);
        }
    </script>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({icons: {time: 'far fa-clock'}});

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                {
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function (start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function (event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function () {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function () {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function (file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function () {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function (progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function (file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function (progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function () {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function () {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {

                initialView: 'dayGridMonth',
                events: [
                    {
                        title: 'event1',
                        start: '2023-08-14',
                    },
                    {
                        title: 'event2',
                        start: '2023-08-12',
                        end: '2023-08-18',
                    },
                    {
                        title: 'event3',
                        start: '2023-08-14T12:30:00',
                        allDay: false // will make the time show
                    }
                ],
                direction: 'rtl',

            });
            calendar.render();
        });

    </script>
@endsection

