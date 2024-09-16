@extends('home')
@section('title')
    ترسية
@endsection
@section('header_title')
    <span>ترسية <span>@if($order->reference_number != 0)
                #{{ $order->reference_number }}
            @endif</span></span>
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    ترسية
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        /* أنماط CSS لشاشة التحميل */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* خلفية شفافة لشاشة التحميل */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* يجعل شاشة التحميل فوق جميع العناصر الأخرى */
        }

        .loader {
            border: 4px solid #f3f3f3; /* لون الدائرة الخارجية */
            border-top: 4px solid #3498db; /* لون الدائرة الداخلية */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite; /* تأثير دوران */
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>

<style>
    .mt-100 {
        margin-top: 150px;
        margin-left: 200px
    }
    /*.card-header {*/
    /*    background-color: #9575CD*/
    /*}*/
    h5 {
        color: #fff
    }
    .card-block {
        margin-top: 10px
    }
    .mytooltip {
        display: inline;
        position: absolute;
        z-index: 999
    }
    .mytooltip .tooltip-item {
        background: rgba(0, 0, 0, 0.1);
        cursor: pointer;
        display: inline-block;
        font-weight: 500;
        padding: 0 10px
    }
    .mytooltip .tooltip-content {
        position: absolute;
        z-index: 9999;
        width: 500px;
        right: 40px;
        /*left: 50%;*/
        margin: 0 0 -40px -180px;
        bottom: 100%;
        text-align: left;
        font-size: 14px;
        line-height: 30px;
        -webkit-box-shadow: -5px -5px 15px rgba(48, 54, 61, 0.2);
        box-shadow: -5px -5px 15px rgba(48, 54, 61, 0.2);
        background: #2b2b2b;
        opacity: 0;
        cursor: default;
        pointer-events: none
    }
    .mytooltip .tooltip-content::after {
        content: '';
        top: 100%;
        right: 0px;
        border: solid transparent;
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-color: #2a3035 transparent transparent;
        border-width: 10px;
        margin-left: -10px
    }
    .mytooltip .tooltip-content img {
        position: relative;
        width: 100%;
        display: block;
        float: left;
        margin-right: 1em
    }
    .mytooltip .tooltip-item::after {
        content: '';
        position: absolute;
        width: 360px;
        height: 20px;
        bottom: 100%;
        left: 50%;
        pointer-events: none;
        -webkit-transform: translateX(-50%);
        transform: translateX(-50%)
    }
    .mytooltip:hover .tooltip-item::after {
        pointer-events: auto
    }
    .mytooltip:hover .tooltip-content {
        pointer-events: auto;
        opacity: 1;
        -webkit-transform: translate3d(0, 0, 0) rotate3d(0, 0, 0, 0deg);
        transform: translate3d(0, 0, 0) rotate3d(0, 0, 0, 0deg)
    }
    .mytooltip:hover .tooltip-content2 {
        opacity: 1;
        font-size: 18px
    }
    .mytooltip .tooltip-text {
        font-size: 14px;
        line-height: 24px;
        display: block;
        padding: 1.31em 1.21em 1.21em 0;
        color: #fff
    }
</style>

@endsection
@section('content')

    {{--    @include('admin.orders.progreesbar')--}}
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    @include('admin.orders.order_menu')
    <div class="modal fade" id="modal-table">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <div class="col-md-11">
                        <span style="font-size: 18px" class="text-bold">جدول مقارنة اسعار الموردين</span>
                    </div>
                    <div class="col-md-1" align="left">
                        <a target="_blank"
                           href="{{ route('procurement_officer.orders.anchor.compare_price_offers',['order_id'=>$order->id]) }}"
                           class="text-white" style="text-decoration: none"><span
                                class="fa fa-print"></span></a>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row m-2" id="table-result">
                         <div class="table-responsive">
                            <table class="table table-sm table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>الاصناف</th>
                                    <th>الكمية</th>
                                    @php
                                        $colCount = -1;
                                    @endphp
                                    @foreach($query as $user)
                                        @foreach($user->user_name as $key)
                                            <th>{{ $key->name }}</th>

                                        @endforeach
                                        @php
                                            $colCount ++;
                                            $sum[$colCount] = 0;
                                        @endphp
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order_items as $order_item)
                                    <tr>
                                        <td>{{ $order_item['product']->product_name_ar }}</td>
                                        <td>{{ $order_item->qty }}</td>
                                        @php
                                            $col = 0;
                                        @endphp
                                        @php
                                            $counter = 0;
                                        @endphp
                                        @foreach($query as $user)
                                            @foreach($user->user_name as $key)
                                                <td>{{  $price = \App\Models\PriceOfferItemsModel::where('order_id',$order_item->order_id)->where('supplier_id',$key->id)->where('product_id',$order_item->product_id)->value('price') }}
                                                    ({{ $total =  (double)($price * $order_item->qty) }})
                                                    @php $sum[$counter] += $total @endphp
                                                </td>
                                                @php
                                                    $counter++;
                                                @endphp
                                            @endforeach
                                            @php
                                                $col++;
                                            @endphp
                                        @endforeach
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2" class="text-center bg-dark">المجموع</td>
                                    @php
                                        $counter = 0;
                                    @endphp
                                    @foreach($query as $user)
                                        @foreach($user->user_name as $key)
                                            <td>{{ $sum[$counter] }}</td>
                                            @php
                                                $counter++;
                                            @endphp
                                        @endforeach
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-add-anchor">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('procurement_officer.orders.anchor.create_anchor') }}" method="post"
                  enctype="multipart/form-data">

                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <div class="col-md-11">
                            <span style="font-size: 18px" class="text-bold">اضافة ترسية</span>
                        </div>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @if($offer_price_anchor->isEmpty())
                            <h3 class="text-center m-3">تم الترسية على جميع الموردين المضافين</h3>
                            <p class="text-center">للترسية على مورد آخر يرجى اضافة عرض سعر للمورد</p>
                        @else
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">اختر عرض سعر</label>
                                        <select class="form-control" required name="offer_price_id" id="">
                                            @foreach($offer_price_anchor as $key)
                                                <option
                                                    value="{{ $key->id }}">{{ $key['supplier']->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">المرفق</label>
                                        <input type="file" name="award_attachment" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">الملاحظة</label>
                                    <textarea class="form-control" name="award_note" id="" cols="30" rows="3"
                                              placeholder="يرجى كتابة الملاحظة الخاصة بالترسية"></textarea>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer justify-content-between">
                        @if(!$offer_price_anchor->isEmpty())
                            <button type="submit" class="btn btn-dark">اضافة</button>
                        @endif
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    </div>
                </div>
            </form>

        </div>

    </div>
    <div class="modal fade" id="modal-update-attachemnt">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('procurement_officer.orders.anchor.upload_image') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" id="price_offer_id" name="price_offer_id">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <div class="col-md-11">
                            <span style="font-size: 18px" class="text-bold">اضافة مرفق للترسية</span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">اضافة مرفق</label>
                                    <input type="file" name="award_attachment" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-dark">اضافة</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    </div>
                </div>
            </form>

        </div>

    </div>

    <div class="card">

        <div class="card-header">
            <h3 class="text-center">الترسية</h3>
        </div>
        <div class="card-body">
            {{--            <div class="row mb-2">--}}
            {{--                <button id="btn_table_result" class="btn btn-primary btn-sm mr-3" onclick="showTableResult()">اظهار جدول المقارنة بين الاسعار</button>--}}
            {{--            </div>--}}
            <button type="button" class="btn btn-dark mb-2" data-toggle="modal" data-target="#modal-add-anchor">
                <span class="fa fa-plus"></span> اضافة ترسية
            </button>
            <button type="button" class="btn btn-warning mb-2" data-toggle="modal" data-target="#modal-table">اظهار جدول
                المقارنة بين الاسعار
            </button>
        </div>

        <div class="row">
            @foreach($anchor as $key)
                <div class="col-md-12 col-sm-6 col-12">
                    <div class="p-3 bg-success">
                    {{-- <div class="info-box bg-success"> --}}
                        <div class="info-box-content">
                            <div class="row">
                                <div class="col-md-5">
                                    <span class="info-box-text">{{ $key['supplier']->name }}</span>
                                </div>
                                <div class="col-md-4 d-flex">
                                    @if(!empty($key->award_attachment))
                                        <a type="text"
                                           href="{{ asset('storage/award_attachment/'.$key->award_attachment) }}"
                                           download="{{ $key->award_attachment }}" class="btn btn-dark btn-sm mr-1"><span
                                                class="fa fa-download"></span><span> تحميل ملف الترسية</span></a>
                                        <button
                                            onclick="viewAttachment({{ $key->id }},'{{ asset('storage/award_attachment/'.$key->award_attachment) }}','{{ $key->note }}')"
                                            href="" class="btn btn-warning btn-sm mr-1" data-toggle="modal"
                                            data-target="#modal-lg-view_attachment"><span
                                                class="fa fa-search"></span><span> عرض ملف الترسية</span></button>
                                        <a class="btn btn-danger btn-sm"
                                           href="{{ route('procurement_officer.orders.anchor.delete_attachment',['id'=>$key->id]) }}"><span
                                                class="fa fa-trash"></span></a>
                                    @else
                                        <button type="button" onclick="get_price_offer_id({{ $key->id }})"
                                                class="btn btn-warning mb-2" data-toggle="modal"
                                                data-target="#modal-update-attachemnt">
                                            <span class="fa fa-file"></span> اضافة مرفق
                                        </button>
                                    @endif
                                </div>
                                <div class="col">
                                    <a onclick="return confirm('هل تريد حذف البيانات ؟؟')"
                                       href="{{ route('procurement_officer.orders.anchor.delete_anchor',['id'=>$key->id]) }}"
                                       class="btn btn-danger btn-sm mr-1"><span class="fa fa-trash"></span><span> الغاء الترسية</span></a>
                                </div>
                                <div class="col d-inline" align="left">
                                    <a target="_blank"
                                       href="{{ route('procurement_officer.orders.anchor.anchor_table_pdf',['order_id'=>$key->order_id,'price_offer'=>$key->id]) }}"
                                       class="text-white" style="text-decoration: none"><span
                                            class="fa fa-print"></span></a>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                                <div class="table-responsive m-3">
                                    <table class="table bg-white table-bordered table-hover table-sm text-center">
                                        <thead>
                                        <tr>
                                            <th>الرقم</th>
                                            <th>الصورة</th>
                                            <th>اسم الصنف</th>
                                            <th>الكمية</th>
                                            <th>الوحدة</th>
                                            <th>السعر</th>
                                            <th>بونص</th>
                                            <th>خصم</th>
                                            <th>الاجمالي</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($order_items->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <span>لا توجد بيانات</span>
                                                </td>
                                            </tr>
                                        @else
                                            @php
                                                $sum = 0;
                                                $bonus = 0;
                                                $discount = 0;
                                                $final_discount_result = 0;
                                            @endphp
                                            @foreach($order_items as $order_item)
                                                @php
                                                    $sum += (double)$order_item->qty * (double) \App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('price');
                                                    $discount += (double) \App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('discount_present');
                                                    $final_discount_result += ((double)$order_item->qty * (double) \App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('price') * (double)\App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('discount_present')) / 100
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>
                                                        @if(empty($order_item['product']->product_photo))
                                                            <img width="50" src="{{ asset('img/no_img.jpeg') }}" alt="">
                                                        @else
                                                        <span class="mytooltip tooltip-effect-1">
                                                            <span class="tooltip-item"
                                                                style='width: 65px;height: 50px;background-image: url("{{ asset('storage/product/'.$order_item['product']->product_photo ) }}");background-size: contain;background-repeat: no-repeat;background-position: center'
                                                            >

                                                            </span>
                                                            <span class="tooltip-content clearfix">
                                                                    <img src="{{ asset('storage/product/'.$order_item['product']->product_photo ) }}">
                                                            </span>
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $order_item['product']->product_name_ar }}</td>
                                                    <td>{{ $order_item->qty }}</td>
                                                    <td>{{ $order_item['unit']->unit_name ?? '' }}</td>
                                                    <td>
                                                        <span>
                                                            {{ (double)\App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('price') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ (double)\App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('bonus') }}
                                                    </td>
                                                    <td>
                                                        <span class="text-danger" style="font-size: 10px">(%{{ (double)\App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('discount_present') }})</span> <br> <span style="font-size: 14px">{{ ((double)$order_item->qty * (double) \App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('price') * (double)\App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('discount_present')) / 100 }}</span>
                                                    </td>
                                                    <td>
                                                        {{ (double)$order_item->qty * (double) \App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('price') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="7" class="text-center bg-dark">المجموع</td>
                                                <td class="text-center bg-danger">{{ $final_discount_result }}</td>
                                                <td class="text-center bg-danger text-white text-bold" dir=""
                                                    style="direction: ltr !important;">@if(!empty($key['currency']))
                                                        {{ $sum }} {{ $key['currency']->currency_name }}
                                                    @endif</td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" class="text-center bg-warning">المجموع الكلي بعد الخصم</td>
                                                <td colspan="2" class="text-center bg-dark">{{ $sum - $final_discount_result }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12" align="center">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="div">
                                                <b style="font-size: 12px">بواسطة
                                                    <span>{{ $key['user']->name }}</span></b>
                                            </div>
                                            {{ $key->insert_at }}
                                        </div>

                                        <div class="col-md-10">
                                                <textarea onchange="updateNote({{ $key->id }},this.value)"
                                                          class="form-control" name="" id="" cols="30"
                                                          rows="3">{{ $key->award_note }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="text-center">
        <p>تم انشاء هذه الطلبية بواسطة <span class="text-danger text-bold">{{ $order['user']->name ?? '' }}</span> ويتم متابعتها بواسطة <span class="text-danger text-bold">{{ $order['to_user']->name ?? '' }}</span></p>
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

        // window.onload = getOrderTable();
    </script>

    <script>
        // $('#table-result').hide();
        // document.getElementById('table-result').style.display = 'none';
        var show = false; // Initially set to false to hide the table

        function showTableResult() {
            show = !show; // Toggle the value of 'show'

            if (show) {
                $('#table-result').show();
                document.getElementById('btn_table_result').innerText = 'اخفاء جدول الاسعار';
            } else {
                $('#table-result').hide();
                document.getElementById('btn_table_result').innerText = 'اظهار جدول المقارنة بين الاسعار';
            }
        }
    </script>

    <script>
        function updateNote(id, value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': csrfToken}});

            $.ajax({
                url: '{{ route('procurement_officer.orders.anchor.updateNotesForAnchor') }}',
                method: 'post',
                data: {
                    'id': id,
                    'award_note': value
                },
                success: function (data) {
                    toastr.success('تم التعديل بنجاح');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                complete: function () {
                    // إخفاء شاشة التحميل بعد انتهاء استدعاء البيانات

                }
            });
        }

        function get_price_offer_id(price_offer_id) {
            document.getElementById('price_offer_id').value = price_offer_id;
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
        })
    </script>

@endsection

