@extends('home')
@section('title')
    طلبات الشراء
@endsection
@section('header_title')
    طلب شراء <span>#{{$order->id}}</span>
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    طلبات الشراء
@endsection
@section('content')
    @section('style')
        <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <style>
            .active {
                color: black !important;
            }

            .nav-link {
                text-decoration: none;
            }
        </style>

        <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
    @endsection
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card @if($order->order_status == 0) bg-warning @else bg-info @endif">
        <div class="card-body">
            <div class="div">
                @if($order->order_status == 0)
                    <spam>حالة الطلب (غير مرسل)</spam> <a class="btn btn-dark btn-sm"
                                                          onclick="return confirm('هل انت متاكد ؟')"
                                                          href="{{ route('orders.updateOrderStatus',['order_id'=>$order->id]) }}">اعتماد
                        وارسال</a>
                    <hr>
                    <p class="text-bold">عند الانتهاء من اضافة الأصناف يرجى الضغط على زر الاعتماد ليتم ارسالها لقسم
                        المشتريات</p>
                @else
                    <spam>حالة الطلب (تم ارسالها الى المشتريات)</spam>
                @endif
            </div>
        </div>
    </div>
    @if(auth()->user()->user_role == 2 || auth()->user()->user_role == 1)
        @include('admin.orders.order_menu')
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">طلب شراء</h3>
        </div>
        <div class="card-body">
            <div class="row">
{{--                <a class="btn btn-dark" href="{{ route('procurement_officer.orders.product.index',['order_id'=>$order->id]) }}">الأصناف</a>--}}
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                        <li class="nav-item @if((session('tab_id')) == null) active @endif  @if(\Illuminate\Support\Facades\Session::has('tab_id')) @if( session('tab_id') == 1)  active @endif @endif ">
                            <a class="nav-link" id="product-tab" data-toggle="pill" href="#product" role="tab"
                               aria-controls="product" aria-selected="true">الأصناف</a>
                        </li>
                        <li class="nav-item @if(\Illuminate\Support\Facades\Session::has('tab_id')) @if( session('tab_id') == 2)  active @endif @endif">
                            <a class="nav-link" id="offer_price-tab" data-toggle="pill" href="#offer_price" role="tab"
                               aria-controls="offer_price"
                               aria-selected="@if(\Illuminate\Support\Facades\Session::has('tab_id')) @if( session('tab_id') == 2) true @else false @endif @endif">عروض
                                الأسعار</a>
                        </li>
                        <li class="nav-item @if(\Illuminate\Support\Facades\Session::has('tab_id')) @if( session('tab_id') == 3)  active @endif @endif">
                            <a class="nav-link" id="anchor-tab" data-toggle="pill" href="#anchor" role="tab"
                               aria-controls="anchor" aria-selected="@if(\Illuminate\Support\Facades\Session::has('tab_id')) @if( session('tab_id') == 2) true @else false @endif @endif">ترسية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="financial-file-tab" data-toggle="pill" href="#financial-file" role="tab"
                               aria-controls="financial-file" aria-selected="">الملف المالي</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="shipping-tab" data-toggle="pill" href="#shipping" role="tab"
                               aria-controls="shipping" aria-selected="false">الشحن</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="insurance-tab" data-toggle="pill" href="#insurance"
                               role="tab" aria-controls="insurance" aria-selected="false">تأمين</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="clearance-tab" data-toggle="pill" href="#clearance" role="tab"
                               aria-controls="clearance" aria-selected="false">تخليص</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="delivery-tab" data-toggle="pill" href="#delivery" role="tab"
                               aria-controls="delivery" aria-selected="false">توصيل</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="calendar-tab" data-toggle="pill" href="#calendar" role="tab"
                               aria-controls="calendar" aria-selected="false">التقويم</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(\Illuminate\Support\Facades\Session::has('tab_id')) @if( session('tab_id') == 9) active @endif @endif" id="attachment-tab" data-toggle="pill" href="#attachment" role="tab"
                               aria-controls="attachment" aria-selected="@if(\Illuminate\Support\Facades\Session::has('tab_id')) @if( session('tab_id') == 9) true @else false @endif @endif">مرفقات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(\Illuminate\Support\Facades\Session::has('tab_id')) @if( session('tab_id') == 10)  active @endif @endif" id="notes-tab" data-toggle="pill" href="#notes" role="tab"
                               aria-controls="notes" aria-selected="@if(\Illuminate\Support\Facades\Session::has('tab_id')) @if( session('tab_id') == 10)  true @else false @endif @endif">ملاحظات</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="custom-content-above-tabContent">
                        <div
                            class="tab-pane fade @if((session('tab_id')) == null) show active @endif @if(\Illuminate\Support\Facades\Session::has('tab_id'))  @if( session('tab_id') == 1) show active  @endif @endif"
                            id="product" role="tabpanel" aria-labelledby="product-tab">
                            <div class="row p-2">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-dark mb-2" data-toggle="modal"
                                            data-target="#modal-lg-product">اضافة صنف
                                    </button>
                                    <div class="table-responsive">
                                        <table class="table table-hover border">
                                            <thead>
                                            <tr>
                                                <th>الرقم</th>
                                                <th>اسم الصنف</th>
                                                <th>الكمية</th>
                                                <th>الوحدة</th>
                                                @if($order->order_status == 0)
                                                    <th>العمليات</th>
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($data->isEmpty())
                                                <tr>
                                                    <td colspan="5" class="text-center"> لا توجد بيانات</td>
                                                </tr>
                                            @else
                                                @foreach($data as $key)
                                                    <tr id="delete_tr_{{$loop->index}}">
                                                        <td>{{ $loop->index+1  }}</td>
                                                        <td>{{ $key['product']->product_name_ar }}</td>
                                                        <td>
                                                            <input onchange="updateQty( this.value  , {{ $key->id }})"
                                                                   id="qty_{{ $loop->index }}" style="width: 80%"
                                                                   class="form-control"
                                                                   type="number" value="{{ $key->qty }}"
                                                                   placeholder="ادخل الكمية">
                                                        </td>
                                                        <td>
                                                            <select onchange="updateUnit(this.value  , {{ $key->id }})"
                                                                    name="product_id"
                                                                    class="form-control select2bs4 select2-hidden-accessible"
                                                                    style="width: 80%;" data-select2-id="{{ $loop->index }}"
                                                                    tabindex="-1"
                                                                    aria-hidden="true">
                                                                @foreach($unit as $unit_key)
                                                                    <option
                                                                        @if(old('unit_id',$key->unit_id) == $unit_key->id) selected
                                                                        @endif value="{{ $unit_key->id }}">{{ $unit_key->unit_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm"
                                                                    onclick="deleteItems({{ $key->id }} , {{ $loop->index }})">
                                                                ازالة
                                                                X
                                                            </button>
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
                        <div
                            class="tab-pane fade @if(\Illuminate\Support\Facades\Session::has('tab_id')) @if( session('tab_id') == 2) show active @endif @endif"
                            id="offer_price" role="tabpanel" aria-labelledby="offer_price-tab">
                            <div class="row p-2">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-dark mb-2" data-toggle="modal"
                                            data-target="#modal-lg-offer_price">اضافة عرض سعر
                                    </button>
                                </div>
                                {{--                                <div class="col-md-12">--}}
                                {{--                                    <table class="table table-bordered">--}}
                                {{--                                        <thead>--}}
                                {{--                                        <tr>--}}
                                {{--                                            <th>المستخدم</th>--}}
                                {{--                                            <th>المورد</th>--}}
                                {{--                                            <th>السعر</th>--}}
                                {{--                                            <th>ملاحظات</th>--}}
                                {{--                                            <th>العمليات</th>--}}
                                {{--                                        </tr>--}}
                                {{--                                        </thead>--}}
                                {{--                                        <tbody>--}}
                                {{--                                        @foreach($offer_price as $key)--}}
                                {{--                                            <tr>--}}
                                {{--                                                <td>{{ $key['user']->name }}</td>--}}
                                {{--                                                <td>{{ $key['supplier']->name }}</td>--}}
                                {{--                                                <td>{{ $key->price }}</td>--}}
                                {{--                                                <td>{{ $key->notes }}</td>--}}
                                {{--                                                <td>--}}
{{--                                                                                    <a href="{{ route('order_items.edit_price_offer',['id'=>$key->id]) }}"--}}
{{--                                                                                       class="btn btn-success btn-sm">تعديل</a>--}}
{{--                                                                                    <a href="{{ route('order_items.details_offer_price',['id'=>$key->id]) }}"--}}
{{--                                                                                       class="btn btn-dark btn-sm">تفاصيل</a>--}}
                                {{--                                                </td>--}}
                                {{--                                            </tr>--}}
                                {{--                                        @endforeach--}}
                                {{--                                        </tbody>--}}
                                {{--                                    </table>--}}

                                @foreach($offer_price as $key)
                                    <div class="col-md-12 col-sm-6 col-12">
                                            <div class="info-box bg-info">
                                                <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
                                                <div class="info-box-content">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <span class="info-box-text">{{ $key['supplier']->name }}</span>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: 100%"></div>
                                                            </div>
                                                            <span class="progress-description">
{{ $key->notes }}
</span>
                                                        </div>
                                                        <div class="col-md-3" align="center">
                                                            <div class="div">
                                                                <b style="font-size: 12px">بواسطة <span>{{ $key['user']->name }}</span></b>
                                                            </div>
                                                            {{ $key->created_at }}
                                                            <div >
                                                                <a href="{{ route('procurement_officer.orders.price_offer.edit_price_offer',['id'=>$key->id]) }}"
                                                                   class="btn btn-success btn-sm">تعديل</a>
                                                                <a href="{{ route('order_items.details_offer_price',['id'=>$key->id]) }}"
                                                                   class="btn btn-danger btn-sm">حذف</a>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>

                                            </div>


                                    </div>
                                @endforeach
                                {{--                                </div>--}}
                            </div>
                        </div>
                        <div class="tab-pane fade @if(\Illuminate\Support\Facades\Session::has('tab_id')) @if( session('tab_id') == 3) show active @endif @endif" id="anchor" role="tabpanel" aria-labelledby="anchor-tab">
                            <div class="p-2">
                                <div class="form-group">
                                    <form action="{{ route('procurement_officer.orders.anchor.create_anchor') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <label for="">اختر عرض سعر</label>
                                        <select required  name="offer_price_id" id="">
                                            @foreach($offer_price_anchor as $key)
                                                <option value="{{ $key->id }}">{{ $key['supplier']->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">اضافة</button>
                                    </form>
                                </div>
                                @foreach($anchor as $key)
                                    <div class="col-md-12 col-sm-6 col-12">
                                        <div class="info-box bg-success">
                                            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
                                            <div class="info-box-content">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <span class="info-box-text">{{ $key['supplier']->name }}</span>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width: 100%"></div>
                                                        </div>
                                                        <span class="progress-description">
{{ $key->notes }}
</span>
                                                    </div>
                                                    <div class="col-md-3" align="center">
                                                        <div class="div">
                                                            <b style="font-size: 12px">بواسطة <span>{{ $key['user']->name }}</span></b>
                                                        </div>
                                                        {{ $key->created_at }}
                                                        <div >
                                                            <a onclick="return confirm('هل تريد حذف البيانات ؟؟')" href="{{ route('procurement_officer.orders.anchor.delete_anchor',['id'=>$key->id]) }}"
                                                               class="btn btn-danger btn-sm">الغاء ترسية</a>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                        </div>


                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="tab-pane fade" id="financial-file" role="tabpanel"
                             aria-labelledby="financial-file">
                            قريبا ..
                        </div>
                        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                            قريبا ..
                        </div>
                        <div class="tab-pane fade" id="insurance" role="tabpanel"
                             aria-labelledby="insurance">
                            قريبا ..
                        </div>
                        <div class="tab-pane fade" id="clearance" role="tabpanel" aria-labelledby="clearance">
                             قريبا ..
                        </div>
                        <div class="tab-pane fade" id="delivery" role="tabpanel" aria-labelledby="delivery-tab">
                            قريبا ..
                        </div>
                        <div class="tab-pane fade" id="calendar" role="tabpanel" aria-labelledby="calendar-tab">
                            قريبا ..
                        </div>
                        <div class="tab-pane fade @if(\Illuminate\Support\Facades\Session::has('tab_id')) @if( session('tab_id') == 9) show active @endif @endif" id="attachment" role="tabpanel" aria-labelledby="attachment-tab">
                            <div class="p-2">
                                <button type="button" class="btn btn-dark mb-2" data-toggle="modal"
                                        data-target="#modal-lg-order_attachment">اضافة مرفق
                                </button>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>الملف</th>
                                            <th>تاريخ الاضافة</th>
                                            <th>الملاحظات</th>
                                            <th>العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($order_attachment->isEmpty())
                                            <tr>
                                                <td class="text-center" colspan="5">لا يوجد مرفقات</td>
                                            </tr>
                                        @endif
                                        @foreach($order_attachment as $key)
                                            <tr>
                                                <td>
                                                    <a target="_blank" href="{{ asset('storage/attachment/'.$key->attachment) }}" download="attachment">تحميل الملف</a>
                                                </td>
                                                <td>{{ $key->insert_at }}</td>
                                                <td>{{ $key->notes }}</td>
                                                <td>
                                                    {{--                                                <a class="btn btn-success btn-sm" href="{{ route('order_items.edit_order_attachment',['id'=>$key->id]) }}">تعديل</a>--}}
                                                    <a class="btn btn-danger btn-sm" onclick="return confirm('هل تريد حذف البيانات ؟؟')" href="{{ route('order_items.delete_order_attachment',['id'=>$key->id]) }}">حذف</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade @if(\Illuminate\Support\Facades\Session::has('tab_id')) @if( session('tab_id') == 10) show active @endif @endif" id="notes" role="tabpanel"
                             aria-labelledby="notes-tab">
                            <div class="p-2">
                                <button type="button" class="btn btn-dark mb-2" data-toggle="modal"
                                        data-target="#modal-lg-order_notes">اضافة ملاحظة
                                </button>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>النص</th>
                                            <th>تاريخ التنبيه</th>
                                            <th>تاريخ الاضافة</th>
                                            {{--                                            <th>المستخدم</th>--}}
                                            <th>العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($order_notes->isEmpty())
                                            <tr>
                                                <td class="text-center" colspan="5">لا يوجد ملاحظات</td>
                                            </tr>
                                        @endif
                                        @foreach($order_notes as $key)
                                            <tr>
                                                <td>{{ $key->note_text }}</td>
                                                <td>{{ $key->alert_date }}</td>
                                                <td>{{ $key->insert_date }}</td>
                                                {{--                                            <td>{{ $key['user']->name }}</td>--}}
                                                <td>
                                                    <a class="btn btn-success btn-sm" href="{{ route('order_items.edit_order_notes',['order_id'=>$key->id]) }}">تعديل</a>
                                                    <a class="btn btn-danger btn-sm" onclick="return confirm('هل تريد حذف البيانات ؟؟')" href="{{ route('order_items.delete_order_notes',['order_id'=>$key->id]) }}">حذف</a>
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


            <div class="modal fade" id="modal-lg-product">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('procurement_officer.orders.create_order_items') }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">اضافة صنف</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div hidden class="form-group">
                                    <label for="">رقم الفاتورة</label>
                                    <input readonly name="order_id" class="form-control" value="{{ $order->id }}"
                                           type="text"
                                    >
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>الصنف</label>
                                            <select id="product" onchange="selectedUnit(this.value)" required
                                                    name="product_id"
                                                    class="form-control select2bs4 select2-hidden-accessible"
                                                    style="width: 100%;" data-select2-id="-1" tabindex="-1"
                                                    aria-hidden="true">
                                                <option value="">اختر صنف</option>
                                                @foreach($product as $key)
                                                    <option value="{{ $key->id }}">{{ $key->product_name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">الكمية</label>
                                            <input name="qty" required class="form-control" type="number"
                                                   placeholder="ادخل الكمية">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>الوحدة</label>
                                            <select id="units" required name="unit_id"
                                                    class="form-control select2bs4 select2-hidden-accessible"
                                                    style="width: 100%;" data-select2-id="-2" tabindex="-1"
                                                    aria-hidden="true">
                                                <option value="" selected>اختر وحدة</option>
                                                @foreach($unit as $key)
                                                    <option value="{{ $key->id }}">{{ $key->unit_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="">ملاحظات</label>
                                    <textarea class="form-control" name="notes" id="" cols="30"
                                              placeholder="ادخل الملاحظات" rows="3"></textarea>
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
            <div class="modal fade" id="modal-lg-offer_price">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('procurement_officer.orders.price_offer.create_price_offer') }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">اضافة عرض سعر</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div hidden class="form-group">
                                            <label for="">رقم الطلبية</label>
                                            <input type="text" value="{{ $order->id }}" name="order_id" readonly
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div hidden class="col-md-6">
                                        <div class="form-group">
                                            <label for="">اسم المستخدم</label>
                                            <input type="text" value="{{ auth()->user()->name }}" readonly
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">المورد</label>
                                            <select class="form-control select2bs4" data-select2-id="3" tabindex="-1"
                                                    tabindex="-1" name="supplier_id" id="">
                                                @foreach($users as $key)
                                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">السعر</label>
                                            <input type="number" step=".01" name="price" class="form-control"
                                                   placeholder="يرجى ادخال السعر">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">العملة</label>
                                            <select class="form-control" name="currency_id" id="">
                                                @foreach($currency as $key)
                                                    <option value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">ارفاق ملف</label>
                                            <input name="attachment" type="file" class="custom-file">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="">ملاحظات</label>
                                                <textarea class="form-control" name="notes" id="" cols="30"
                                                          rows="2"></textarea>
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
            <div class="modal fade" id="modal-lg-order_notes">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('procurement_officer.orders.notes.create_order_notes') }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">اضافة ملاحظة</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                        @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <div class="col-md-12">
                                            <label for="">نص الملاحظة</label>
                                            <textarea class="form-control" name="note_text" id="" cols="30" rows="4" placeholder="يرجى كتابة الملاحظة"></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="">تاريخ التنبيه</label>
                                            <input name="alert_date" type="date" class="form-control text-center">
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
            <div class="modal fade" id="modal-lg-order_attachment">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('procurement_officer.orders.attachment.create_order_attachment') }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $order->id }}" name="order_id">
                            <div class="modal-header">
                                <h4 class="modal-title">اضافة مرفق</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                        @csrf

                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">يرجى ارفاق الملف</label>
                                                <input name="attachment" type="file" class="form-control">

                                            </div>
                                        </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">اضافة ملاحظة</label>
                                            <textarea class="form-control" name="notes" id="" cols="30" rows="3"></textarea>
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

        </div>

    </div>

@endsection()

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
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>

    <script>
        function updateQty(qty, order_items_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ url('orders/updateQtyForOrder_items') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': {{ $order->id }},
                    'order_items_id': order_items_id,
                    'qty': qty
                },
                success: function (data) {
                    toastr.success('تم تعديل الكمية بنجاح')
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function updateUnit(unit_id, order_items_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ url('orders/updateUnitOrder_items') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': {{ $order->id }},
                    'order_items_id': order_items_id,
                    'unit_id': unit_id
                },
                success: function (data) {
                    toastr.success('تم تعديل الوحدة بنجاح')
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function deleteItems(order_items_id, index) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ url('orders/deleteItems') }}' + '/' + order_items_id,
                method: 'get',
                headers: headers,
                {{--data: {--}}
                    {{--    'order_id': {{ $order->id }},--}}
                    {{--    'order_items_id': order_items_id,--}}
                    {{--},--}}
                success: function (data) {
                    document.getElementById('delete_tr_' + index).remove();
                    toastr.success('تم الحذف بنجاح')
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        var products = {!! json_encode($product) !!};
        var units = {!! json_encode($unit) !!};

        function selectedUnit(product_id) {
            var selectedProduct = products.find(function (product) {
                return product.id == product_id;
            });

            if (selectedProduct) {
                // Get the unit_id linked to the selected product
                var selectedUnitId = selectedProduct.unit_id;

                // Populate the "Units" select with all units
                var unitsSelect = $('#units');
                unitsSelect.empty(); // Clear previous options

                // Add the default option
                unitsSelect.append($('<option>', {
                    value: '',
                    text: 'اختر وحدة',
                    selected: true
                }));

                // Add the options for each unit
                units.forEach(function (unit) {
                    unitsSelect.append($('<option>', {
                        value: unit.id,
                        text: unit.unit_name,
                        selected: unit.id == selectedUnitId // Select the unit linked to the selected product
                    }));
                });

                // Refresh the select2 plugin (if you are using it)
                unitsSelect.trigger('change');
            }
        }
    </script>

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
        $(function () {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $('.swalDefaultSuccess').click(function () {
                Toast.fire({
                    icon: 'success',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultInfo').click(function () {
                Toast.fire({
                    icon: 'info',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultError').click(function () {
                Toast.fire({
                    icon: 'error',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultWarning').click(function () {
                Toast.fire({
                    icon: 'warning',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultQuestion').click(function () {
                Toast.fire({
                    icon: 'question',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });

            $('.toastrDefaultSuccess').click(function () {
                toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultInfo').click(function () {
                toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultError').click(function () {
                toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultWarning').click(function () {
                toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });

            $('.toastsDefaultDefault').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultTopLeft').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    position: 'topLeft',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultBottomRight').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    position: 'bottomRight',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultBottomLeft').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    position: 'bottomLeft',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultAutohide').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    autohide: true,
                    delay: 750,
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultNotFixed').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    fixed: false,
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultFull').click(function () {
                $(document).Toasts('create', {
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    icon: 'fas fa-envelope fa-lg',
                })
            });
            $('.toastsDefaultFullImage').click(function () {
                $(document).Toasts('create', {
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    image: '../../dist/img/user3-128x128.jpg',
                    imageAlt: 'User Picture',
                })
            });
            $('.toastsDefaultSuccess').click(function () {
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultInfo').click(function () {
                $(document).Toasts('create', {
                    class: 'bg-info',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultWarning').click(function () {
                $(document).Toasts('create', {
                    class: 'bg-warning',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultDanger').click(function () {
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultMaroon').click(function () {
                $(document).Toasts('create', {
                    class: 'bg-maroon',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
        });

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

@endsection

