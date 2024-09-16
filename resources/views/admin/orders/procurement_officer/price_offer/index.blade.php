@extends('home')
@section('title')
    عرض شراء
@endsection
@section('header_title')
    <span>عرض شراء <span>
            @if ($order->reference_number != 0)
                #{{ $order->reference_number }}
            @endif
        </span></span>
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    تفاصيل عرض شراء
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
            background-color: rgba(0, 0, 0, 0.5);
            /* خلفية شفافة لشاشة التحميل */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            /* يجعل شاشة التحميل فوق جميع العناصر الأخرى */
        }

        .loader {
            border: 4px solid #f3f3f3;
            /* لون الدائرة الخارجية */
            border-top: 4px solid #3498db;
            /* لون الدائرة الداخلية */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
            /* تأثير دوران */
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

        /*.popup {*/
        /*    position: relative;*/
        /*    display: inline-block;*/
        /*    cursor: pointer;*/
        /*    -webkit-user-select: none;*/
        /*    -moz-user-select: none;*/
        /*    -ms-user-select: none;*/
        /*    user-select: none;*/
        /*}*/


        /*!* The actual popup *!*/

        /*.popup .popuptext {*/
        /*    visibility: hidden;*/
        /*    width: 400px;*/
        /*    background-color: #555;*/
        /*    color: #fff;*/
        /*    text-align: center;*/
        /*    border-radius: 6px;*/
        /*    padding: 8px 0;*/
        /*    position: absolute;*/
        /*    z-index: 1;*/
        /*    top: -100%;*/
        /*    margin-left: -80px;*/
        /*}*/


        /*!* Popup arrow *!*/

        /*.popup .popuptext::after {*/
        /*    content: "";*/
        /*    position: absolute;*/
        /*    top: 100%;*/
        /*    left: 50%;*/
        /*    margin-left: -5px;*/
        /*    border-width: 5px;*/
        /*    border-style: solid;*/
        /*    border-color: #555 transparent transparent transparent;*/
        /*}*/


        /*!* Toggle this class - hide and show the popup *!*/

        /*.popup .show {*/
        /*    visibility: visible;*/
        /*    -webkit-animation: fadeIn 1s;*/
        /*    animation: fadeIn 1s;*/
        /*}*/

        /*.popup #b1:hover + .popuptext {*/
        /*    visibility: visible;*/
        /*    opacity: 1;*/
        /*}*/


        /*!* Add animation (fade in the popup) *!*/

        /*@-webkit-keyframes fadeIn {*/
        /*    from {*/
        /*        opacity: 0;*/
        /*    }*/
        /*    to {*/
        /*        opacity: 1;*/
        /*    }*/
        /*}*/

        /*@keyframes fadeIn {*/
        /*    from {*/
        /*        opacity: 0;*/
        /*    }*/
        /*    to {*/
        /*        opacity: 1;*/
        /*    }*/
        /*}*/

        .tooltipIcon {
            position: relative;
            cursor: pointer;
        }

        .popup {
            margin-left: 100px;
            display: none;
            margin-bottom: 100%;
            position: fixed;
            justify-content: start;
            width: 400px;
            top: -1000px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .popup.visible {
            display: block;
        }

    </style>
@endsection
@section('content')
    {{--    @include('admin.orders.progreesbar') --}}
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    @include('admin.orders.order_menu')
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">عروض الأسعار</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark mb-2" data-toggle="modal"
                        data-target="#modal-lg-offer_price">
                        <span class="fa fa-plus"></span> اضافة عرض سعر
                    </button>
                    <a class="btn btn-success mb-2"
                        href="{{ route('procurement_officer.orders.price_offer.exportExcel', ['order_id' => $order->id]) }}">تصدير
                        الى اكسيل</a>
                </div>

                @foreach ($data as $key)
{{--                    <div id="popup_{{ $key->id }}" class="popup">--}}

{{--                    </div>--}}
                    <div class="col-md-12 col-sm-6 col-12">
                        <div class="info-box bg-info">
                            {{-- <span class="info-box-icon"><i class="far fa-bookmark"></i></span> --}}
                            <div class="info-box-content">
                                <div class="row">
                                    <div class="col-md-10">
                                        <span class="info-box-text">{{ $key['supplier']->name }}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                        <span>
                                            {{ $key->notes }}
                                        </span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                        <div class="table-responsive mt-2">
                                            <table class="table bg-white table-bordered table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>الرقم</th>
                                                        <th>الصورة</th>
                                                        <th>اسم الصنف</th>
                                                        <th>الكمية</th>
                                                        <th>الوحدة</th>
                                                        <th>السعر</th>
                                                        <th>بونص</th>
                                                        <th>خصم %</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($order_items->isEmpty())
                                                        <tr>
                                                            <td colspan="5" class="text-center">
                                                                <span>لا توجد بيانات</span>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        @foreach ($order_items as $order_item)
                                                            <tr>
                                                                <td>{{ $loop->index + 1 }}</td>
                                                                <td>
                                                                    <span class="mytooltip tooltip-effect-1">
                                                                        <span class="tooltip-item"
                                                                            style='width: 65px;height: 50px;background-image: url("{{ asset('storage/product/' . $order_item['product']->product_photo) }}");background-size: contain;background-repeat: no-repeat;background-position: center'>

                                                                        </span>
                                                                        <span class="tooltip-content clearfix">
                                                                            <img
                                                                                src="{{ asset('storage/product/' . $order_item['product']->product_photo) }}">
                                                                        </span>
                                                                    </span>
                                                                </td>
                                                                <td>{{ $order_item['product']->product_name_ar }}</td>
                                                                <td>{{ $order_item->qty }}</td>
                                                                <td>
                                                                    @if (!empty($order_item['unit']->unit_name))
                                                                        {{ $order_item['unit']->unit_name }}
                                                                    @endif
                                                                </td>
                                                                <td>

                                                                 <div style="display: flex;justify-content: center;align-items: center;gap: 10px">
                                                                     <input style="background-color:#fff4c9"
                                                                            onchange="AddOrUpdatePrice({{ $key['supplier']->id }},{{ $order_item->product_id }},this.value)"
                                                                            value="{{ \App\Models\PriceOfferItemsModel::where('order_id', $key->order_id)->where('product_id', $order_item->product_id)->where('supplier_id', $key['supplier']->id)->value('price') }}"
                                                                            type="text" class="form-control text-center">
                                                                     <span
                                                                         onclick="get_product_for_other_orders({{$key->id}},{{ $order_item['product']->id }})"
{{--                                                                         onmouseout="hideTooltip({{$key->id}})"--}}
                                                                         class="fa fa-info-circle tooltipIcon"
                                                                     >
                                                                        </span>
                                                                 </div>
                                                                <td>
                                                                    <input
                                                                        onchange="add_or_update_bonus({{ $key['supplier']->id }},{{ $order_item->product_id }},this.value)"
                                                                        class="form-control text-center" type="text"
                                                                        value="{{ \App\Models\PriceOfferItemsModel::where('order_id', $key->order_id)->where('product_id', $order_item->product_id)->where('supplier_id', $key['supplier']->id)->value('bonus') }}">
                                                                </td>
                                                                <td>
                                                                    <input
                                                                        onchange="add_or_update_discount({{ $key['supplier']->id }},{{ $order_item->product_id }},this.value)"
                                                                        class="form-control text-center" type="text"
                                                                        value="{{ \App\Models\PriceOfferItemsModel::where('order_id', $key->order_id)->where('product_id', $order_item->product_id)->where('supplier_id', $key['supplier']->id)->value('discount_present') }}">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-2" align="center">
                                        <div class="mt-2">
                                            <label for="">العملة</label>
                                            <select onchange="updateCurrency({{ $key['supplier']->id }},this.value)"
                                                class="form-control" name="" id="">
                                                @foreach ($currency as $cur)
                                                    <option @if ($cur->id == $key->currency_id) selected @endif
                                                        value="{{ $cur->id }}">{{ $cur->currency_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="div">
                                            <b style="font-size: 12px">بواسطة <span>{{ $key['user']->name }}</span></b>
                                        </div>
                                        {{ $key->created_at }}
                                        <div>
                                            <a href="{{ route('procurement_officer.orders.price_offer.edit_price_offer', ['id' => $key->id]) }}"
                                                class="btn btn-success btn-sm">تعديل</a>
                                            <a href="{{ route('procurement_officer.orders.price_offer.delete_offer_price', ['id' => $key->id]) }}"
                                                class="btn btn-danger btn-sm">حذف</a>
                                        </div>
                                        <div class="mt-2">
                                            @if (!empty($key->attachment))
                                                <a type="text"
                                                    href="{{ asset('storage/attachment/' . $key->attachment) }}"
                                                    download="{{ $key->attachment }}" class="btn btn-primary btn-sm"><span
                                                        class="fa fa-download"></span></a>
                                                <button
                                                    onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/' . $key->attachment) }}',null)"
                                                    href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                    data-target="#modal-lg-view_attachment"><span
                                                        class="fa fa-search"></span></button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <button onclick="getOrderIdAndSupplierId({{ $order->id }},{{ $key->supplier_id }})"
                                    class="btn btn-success btn-sm" data-toggle="modal"
                                    data-target="#modal-lg-import">استيراد من اكسيل
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="tooltipContent" style="display:none;">

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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">المورد</label>
                                    <select class="form-control select2bs4" data-select2-id="3" tabindex="-1"
                                        tabindex="-1" name="supplier_id" id="">
                                        @foreach ($users as $key)
                                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{--                            <div class="col-md-3"> --}}
                            {{--                                <div class="form-group"> --}}
                            {{--                                    <label for="">السعر</label> --}}
                            {{--                                    <input type="number" step=".01" name="price" class="form-control" --}}
                            {{--                                           placeholder="يرجى ادخال السعر"> --}}
                            {{--                                </div> --}}
                            {{--                            </div> --}}
                            {{--                            <div class="col-md-3"> --}}
                            {{--                                <div class="form-group"> --}}
                            {{--                                    <label for="">العملة</label> --}}
                            {{--                                    <select class="form-control" name="currency_id" id=""> --}}
                            {{--                                        @foreach ($currency as $key) --}}
                            {{--                                            <option value="{{ $key->id }}">{{ $key->currency_name }}</option> --}}
                            {{--                                        @endforeach --}}
                            {{--                                    </select> --}}
                            {{--                                </div> --}}
                            {{--                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">ارفاق ملف</label>
                                    <input name="attachment" type="file" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">ملاحظات</label>
                                    <textarea class="form-control" name="notes" id="" cols="30" rows="2"></textarea>
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
    <div class="modal fade" id="modal-lg-import">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('procurement_officer.orders.price_offer.importExcel') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="order_id" id="order_id">
                    <input type="hidden" name="supplier_id" id="supplier_id">
                    <div class="modal-header">
                        <h4 class="modal-title">استيراد من اكسيل</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">ارفاق ملف</label>
                                    <input name="file" type="file" class="form-control">
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
    <div class="text-center">
        <p>تم انشاء هذه الطلبية بواسطة <span class="text-danger text-bold">{{ $order['user']->name ?? '' }}</span> ويتم
            متابعتها بواسطة <span class="text-danger text-bold">{{ $order['to_user']->name ?? '' }}</span></p>
    </div>
    </div>

    @include('admin.orders.procurement_officer.price_offer.modals.product_table_from_price_offer')
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

    <script>
        function getOrderIdAndSupplierId(order_id, supplier_id) {
            document.getElementById('order_id').value = order_id;
            document.getElementById('supplier_id').value = supplier_id;
        }
    </script>

    <script>


        function get_product_for_other_orders(index,productId) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            // document.getElementById('popup_'+index).innerHTML = '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '{{ route('procurement_officer.orders.price_offer.get_product_for_other_orders') }}',
                method: 'post',
                headers: headers,
                data: {
                    'product_id': productId,
                },
                success: function(data) {
                    $('#product_table_from_price_offer_modal').modal('show');
                    $('#product_price_offer_name').html(data.product.product_name_ar)
                    console.log(data);
                    const routeUrl = "{{ route('procurement_officer.orders.product.index', ['order_id' => ':order_id']) }}";
                    popupContent = '';
                    console.log(data);
                    if (data.success === 'true'){
                        if (data.data == ''){
                            popupContent = 'لا توجد بيانات لهذا الصنف'
                        }
                        else{
                            let rows = data.data.map(item => {
                                let url = routeUrl.replace(':order_id', item.order.id);
                                return `
                                    <tr>
                                        <td>
                                            <a target="_blank" href="${url}">${item.order.reference_number}</a>
                                        </td>
                                        <td>${item.price}</td>
                                        <td>${item.order.inserted_at}</td>
                                    </tr>
                                `;
                            }).join('');
                            popupContent = `
                                <table class="table table-sm table-border table-hover text-center">
                                    <tr>
                                        <th>الطلب</th>
                                        <th>السعر</th>
                                        <th>التاريخ</th>
                                    </tr>
                                    ${rows}
                                </table>
                            `;
                        }
                    }

                    const popup = document.getElementById('product_table_price_offer');
                    popup.innerHTML = popupContent;

                    const tooltipIcon = document.querySelector('.tooltipIcon');
                    const rect = tooltipIcon.getBoundingClientRect();
                    popup.style.top = `0`;
                    popup.style.left = `-90px`;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                    alert('error');
                }
            });
        }

        // function hideTooltip(index) {
        //     console.log('Mouse out detected'); // Debugging log
        //
        //     const popup = document.getElementById('popup_'+index);
        //     popup.classList.remove('visible');
        // }


        function AddOrUpdatePrice(supplier_id, product_id, price) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ url('users/procurement_officer/orders/price_offer_items/create') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': {{ $order->id }},
                    'supplier_id': supplier_id,
                    'product_id': product_id,
                    'price': price
                },
                success: function(data) {
                    console.log(data);
                    toastr.success('تم تعديل السعر بنجاح')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                    alert('error');
                }
            });
        }

        function updateCurrency(supplier_id, currency_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('procurement_officer.orders.price_offer.updateCurrency') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': {{ $order->id }},
                    'supplier_id': supplier_id,
                    'currency_id': currency_id
                },
                success: function(data) {
                    console.log(data);
                    toastr.success('تم تعديل العملة بنجاح')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                    alert('error');
                }
            });
        }

        function add_or_update_bonus(supplier_id, product_id, bonus) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('procurement_officer.orders.price_offer_items.add_or_update_bonus') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': {{ $order->id }},
                    'supplier_id': supplier_id,
                    'product_id': product_id,
                    'bonus': bonus
                },
                success: function(data) {
                    console.log(data);
                    toastr.success('تم تعديل العلاوة بنجاح')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }

        function add_or_update_discount(supplier_id, product_id, discount_present) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('procurement_officer.orders.price_offer_items.add_or_update_discount') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': {{ $order->id }},
                    'supplier_id': supplier_id,
                    'product_id': product_id,
                    'discount_present': discount_present
                },
                success: function(data) {
                    console.log(data);
                    toastr.success('تم تعديل الخصم بنجاح')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }

        function show_product_details() {
            alert('asd')
            $('#tooltip_product').tooltip('show');
        }
    </script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
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
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $('.swalDefaultSuccess').click(function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultInfo').click(function() {
                Toast.fire({
                    icon: 'info',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultError').click(function() {
                Toast.fire({
                    icon: 'error',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultWarning').click(function() {
                Toast.fire({
                    icon: 'warning',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultQuestion').click(function() {
                Toast.fire({
                    icon: 'question',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });

            $('.toastrDefaultSuccess').click(function() {
                toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultInfo').click(function() {
                toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultError').click(function() {
                toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultWarning').click(function() {
                toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });

            $('.toastsDefaultDefault').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultTopLeft').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    position: 'topLeft',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultBottomRight').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    position: 'bottomRight',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultBottomLeft').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    position: 'bottomLeft',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultAutohide').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    autohide: true,
                    delay: 750,
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultNotFixed').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    fixed: false,
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultFull').click(function() {
                $(document).Toasts('create', {
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    icon: 'fas fa-envelope fa-lg',
                })
            });
            $('.toastsDefaultFullImage').click(function() {
                $(document).Toasts('create', {
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    image: '../../dist/img/user3-128x128.jpg',
                    imageAlt: 'User Picture',
                })
            });
            $('.toastsDefaultSuccess').click(function() {
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultInfo').click(function() {
                $(document).Toasts('create', {
                    class: 'bg-info',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultWarning').click(function() {
                $(document).Toasts('create', {
                    class: 'bg-warning',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultDanger').click(function() {
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultMaroon').click(function() {
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
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection
