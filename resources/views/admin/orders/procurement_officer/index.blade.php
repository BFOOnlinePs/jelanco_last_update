{{-- @extends('home') --}}
{{-- @section('title') --}}
{{--    طلبات الشراء --}}
{{-- @endsection --}}
{{-- @section('header_title') --}}
{{--    طلبات الشراء --}}
{{-- @endsection --}}
{{-- @section('header_link') --}}
{{--    الرئيسية --}}
{{-- @endsection --}}
{{-- @section('header_title_link') --}}
{{--    طلبات الشراء --}}
{{-- @endsection --}}
{{-- @section('style') --}}
{{--    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}"> --}}
{{--    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"> --}}
{{--    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}"> --}}
{{--    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}"> --}}
{{--    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}"> --}}
{{--    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}"> --}}
{{--    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}"> --}}
{{--    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}"> --}}
{{--    <style> --}}
{{--        /* أنماط CSS لشاشة التحميل */ --}}
{{--        .loader-container { --}}
{{--            position: fixed; --}}
{{--            top: 0; --}}
{{--            left: 0; --}}
{{--            width: 100%; --}}
{{--            height: 100%; --}}
{{--            background-color: rgba(0, 0, 0, 0.5); /* خلفية شفافة لشاشة التحميل */ --}}
{{--            display: flex; --}}
{{--            justify-content: center; --}}
{{--            align-items: center; --}}
{{--            z-index: 9999; /* يجعل شاشة التحميل فوق جميع العناصر الأخرى */ --}}
{{--        } --}}

{{--        .loader { --}}
{{--            border: 4px solid #f3f3f3; /* لون الدائرة الخارجية */ --}}
{{--            border-top: 4px solid #3498db; /* لون الدائرة الداخلية */ --}}
{{--            border-radius: 50%; --}}
{{--            width: 50px; --}}
{{--            height: 50px; --}}
{{--            animation: spin 2s linear infinite; /* تأثير دوران */ --}}
{{--        } --}}

{{--        @keyframes spin { --}}
{{--            0% { --}}
{{--                transform: rotate(0deg); --}}
{{--            } --}}
{{--            100% { --}}
{{--                transform: rotate(360deg); --}}
{{--            } --}}
{{--        } --}}

{{--        /*.select2-container--default .select2-selection--single {*/ --}}
{{--        /*    background-color: #FFA500; !* Change this to your desired color *!*/ --}}
{{--        /*    color: #fff; !* Change this to your desired text color *!*/ --}}
{{--        /*}*/ --}}

{{--        /*!* Change the background color of the dropdown options *!*/ --}}
{{--        /*.select2-results__option {*/ --}}
{{--        /*    background-color: green; !* Change this to your desired option color *!*/ --}}
{{--        /*}*/ --}}

{{--        .select2-selection__rendered{ --}}
{{--            background-color: white; --}}
{{--            color: black; --}}
{{--        } --}}
{{--    </style> --}}
{{-- @endsection --}}
{{-- @section('content') --}}

{{--    @include('admin.messge_alert.success') --}}
{{--    @include('admin.messge_alert.fail') --}}

{{--    @if (auth()->user()->user_role != 3 && auth()->user()->user_role != 9) --}}
{{--        <button type="button" class="btn btn-dark mb-2" data-toggle="modal" data-target="#modal-default"><span class="fa fa-plus"></span> طببية جديدة --}}
{{--        </button> --}}
{{--        <a href="{{ route('orders.procurement_officer.order_index') }}" class="btn btn-success mb-2"> --}}
{{--            <span class="fa fa-list"></span>   الطلبيات --}}
{{--        </a> --}}
{{--        <a href="{{ route('orders.procurement_officer.list_orders_from_storekeeper') }}" class="btn btn-info mb-2"><span class="fa fa-building"></span> الطلبيات الواردة من المستودع</a> --}}
{{--        <a href="{{ route('order_archive.index') }}" class="btn btn-warning mb-2"><span class="fa fa-building"></span> ارشيف الطلبات</a> --}}
{{--        <a href="{{ route('trash.index') }}" class="btn btn-danger mb-2"> --}}
{{--            <span class="fa fa-trash"></span> الطلبيات المحذوفة --}}
{{--        </a> --}}
{{--        <button onclick="PrintOrderPDF()" class="float-right btn btn-dark"><span class="fa fa-print"></span> طباعة</button> --}}
{{--    @endif --}}
{{--    --}}{{--        <form id="order_form" action="{{ route('orders.procurement_officer.create_order') }}" method="POST"> --}}
{{--    --}}{{--            @csrf --}}
{{--    --}}{{--            <input type="hidden" name="order_type" value="1"> --}}
{{--    --}}{{--            --}}{{-- --}}{{--        <button type="submit" class="btn btn-primary mb-2" onclick="return confirm('هل تريد اضافة طلبية شراء جديدة؟')" >اضافة طلبية شراء</button> --}}
{{--    --}}{{--            <button type="submit" class="btn btn-dark mb-2">اضافة طلبية شراء</button> --}}
{{--    --}}{{--        </form> --}}
{{--    <div class="card bg-gradient-info"> --}}
{{--        <div class="card-body"> --}}
{{--            <div class="row"> --}}
{{--                <div class="col"> --}}
{{--                    <div class="form-group"> --}}
{{--                        <label for="">رقم المرجع</label> --}}
{{--                        <input onkeyup="getOrderTable()" placeholder="رقم المرجع" id="reference_number" name="reference_number" --}}
{{--                               class="form-control" type="text"> --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--                <div class="col"> --}}
{{--                    <div class="form-group"> --}}
{{--                        <label for="">المورد</label> --}}
{{--                        <select onchange="getOrderTable()" class="select2bs4 form-control supplier_select2" name="supplier_id" id="supplier_id"> --}}
{{--                            <option value="">جميع الموردين</option> --}}
{{--                            @foreach ($supplier as $key) --}}
{{--                                <option value="{{ $key->id }}">{{ $key->name }}</option> --}}
{{--                            @endforeach --}}
{{--                        </select> --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--                <div class="col"> --}}
{{--                    <div class="form-group"> --}}
{{--                        <label for="">متابعة بواسطة</label> --}}
{{--                        <select onchange="getOrderTable()" class="select2bs4 form-control supplier_select2" name="to_user" id="to_user"> --}}
{{--                            <option value="">جميع المستخدمين</option> --}}
{{--                            @foreach ($users as $key) --}}
{{--                                <option value="{{ $key->id }}">{{ $key->name }}</option> --}}
{{--                            @endforeach --}}
{{--                        </select> --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--                <div class="col"> --}}
{{--                    <div class="form-group"> --}}
{{--                        <label for="">مجال العمل</label> --}}
{{--                        <select onchange="getOrderTable()" class="select2bs4 form-control supplier_select2" name="user_category" id="user_category"> --}}
{{--                            <option value="">جميع مجالات العمل</option> --}}
{{--                            @foreach ($user_category as $key) --}}
{{--                                <option value="{{ $key->id }}">{{ $key->name }}</option> --}}
{{--                            @endforeach --}}
{{--                        </select> --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--                <div class="col"> --}}
{{--                    <div class="form-group"> --}}
{{--                        <label for="">حالة الطلبية</label> --}}
{{--                        <select onchange="getOrderTable()" class="form-control" name="order_status" id="order_status"> --}}
{{--                            <option value="">جميع الحالات</option> --}}
{{--                            @foreach ($order_status as $key) --}}
{{--                                @if ($key->id != 10) --}}
{{--                                    <option value="{{ $key->id }}">{{ $key->name }}</option> --}}
{{--                                @endif --}}
{{--                            @endforeach --}}
{{--                        </select> --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--                <div class="col"> --}}
{{--                    <div class="form-group"> --}}
{{--                        <label for="">من تاريخ</label> --}}
{{--                        --}}{{-- <input onchange="getOrderTable()" name="from" id="from" value="<?php echo date('Y-01-01'); ?>" type="text" class="form-control date_format"> --}}
{{--                        <input onchange="getOrderTable()" name="from" id="from" value="<?php echo '2023-01-01'; ?>" type="text" class="form-control date_format"> --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--                <div class="col"> --}}
{{--                    <div class="form-group"> --}}
{{--                        <label for="">الى تاريخ</label> --}}
{{--                        <input onchange="getOrderTable()" name="to" id="to" value="<?php echo date('Y-m-d'); ?>" type="text" class="form-control date_format"> --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--            </div> --}}
{{--        </div> --}}
{{--    </div> --}}

{{--    <div class="card"> --}}
{{--        <div class="card-header"> --}}
{{--            <h3 class="text-center">قائمة طلبات الشراء</h3> --}}
{{--        </div> --}}
{{--        <div class=""> --}}
{{--            <input hidden class="form-control mb-2" type="text" id="search_order_number" onkeyup="getOrderTable()" --}}
{{--                   placeholder="بحث عن رقم الفاتورة"> --}}
{{--            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 mt-3"> --}}
{{--                <div class="row text-center" id="order_table"> --}}

{{--                </div> --}}
{{--            </div> --}}
{{--        </div> --}}
{{--        <div class="loader-container" id="loaderContainer" style="display: none;"> --}}
{{--            <div class="loader"></div> <!-- دائرة الـ Loader --> --}}
{{--        </div> --}}
{{--    </div> --}}

{{--    <div class="modal fade" id="modal-default"> --}}
{{--        <div class="modal-dialog modal-default"> --}}
{{--            <form onsubmit="return " action="{{ route('orders.procurement_officer.create_order') }}" method="post" --}}
{{--                  enctype="multipart/form-data"> --}}
{{--                @csrf --}}
{{--                <div class="modal-content"> --}}
{{--                    <div class="modal-header"> --}}
{{--                        <h4 class="modal-title">اضافة طلبية شراء</h4> --}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> --}}
{{--                            <span aria-hidden="true">&times;</span> --}}
{{--                        </button> --}}
{{--                    </div> --}}
{{--                    <div class="modal-body"> --}}
{{--                        <div class="form-group"> --}}
{{--                            <label>اسم المورد</label> --}}
{{--                            <select required class="select2bs4 select2-hidden-accessible" multiple="" --}}
{{--                                    name="supplier[]" --}}
{{--                                    style="width: 100%;"> --}}
{{--                                @foreach ($supplier as $key) --}}
{{--                                    <option value="{{ $key->id }}">{{ $key->name }}</option> --}}
{{--                                @endforeach --}}
{{--                            </select> --}}
{{--                        </div> --}}
{{--                        <div class="form-group"> --}}
{{--                            <label for="">الرقم المرجعي</label> --}}
{{--                            <input name="reference_number" value="" id="reference_number" type="text" class="form-control" --}}
{{--                                   placeholder="الرقم المرجعي"> --}}
{{--                        </div> --}}
{{--                    </div> --}}
{{--                    <div class="modal-footer justify-content-between"> --}}
{{--                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button> --}}
{{--                        <button type="submit" class="btn btn-primary">حفظ</button> --}}
{{--                    </div> --}}

{{--                </div> --}}
{{--            </form> --}}

{{--        </div> --}}
{{--    </div> --}}
{{--    <div class="modal fade" id="modal-reference_number"> --}}
{{--        <div class="modal-dialog modal-default"> --}}
{{--            <form action="{{ route('orders.procurement_officer.update_reference_number') }}" method="post" --}}
{{--                  enctype="multipart/form-data"> --}}
{{--                @csrf --}}
{{--                <input type="hidden" id="order_id" name="order_id"> --}}
{{--                <div class="modal-content"> --}}
{{--                    <div class="modal-header"> --}}
{{--                        <h4 class="modal-title">تعديل الرقم المرجعي</h4> --}}
{{--                        <h4 class="modal-title">تعديل الرقم المرجعي</h4> --}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> --}}
{{--                            <span aria-hidden="true">&times;</span> --}}
{{--                        </button> --}}
{{--                    </div> --}}
{{--                    <div class="modal-body"> --}}
{{--                        <div class="form-group"> --}}
{{--                            <label>الرقم المرجعي</label> --}}
{{--                            <input type="text" class="form-control" name="reference_number" id="reference_number_value" --}}
{{--                                   required> --}}
{{--                        </div> --}}
{{--                    </div> --}}
{{--                    <div class="modal-footer justify-content-between"> --}}
{{--                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button> --}}
{{--                        <button type="submit" class="btn btn-primary">حفظ</button> --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--            </form> --}}

{{--        </div> --}}
{{--    </div> --}}
{{--    <div class="modal fade" id="modal-show_due_date"> --}}
{{--        <div class="modal-dialog modal-default"> --}}
{{--            <form onsubmit="return dateValidation()" action="{{ route('orders.procurement_officer.update_due_date') }}" method="post" --}}
{{--                  enctype="multipart/form-data"> --}}
{{--                @csrf --}}
{{--                <input type="hidden" id="order_id_due_date" name="order_id"> --}}
{{--                <div class="modal-content"> --}}
{{--                    <div class="modal-header"> --}}
{{--                        <h4 class="modal-title">تعديل تاريخ الطلبية</h4> --}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> --}}
{{--                            <span aria-hidden="true">&times;</span> --}}
{{--                        </button> --}}
{{--                    </div> --}}
{{--                    <div class="modal-body"> --}}
{{--                        <div class="form-group"> --}}
{{--                            <label>تاريخ الطلبية</label> --}}
{{--                            <input type="text" class="form-control date_format" name="due_date" id="due_date_value" --}}
{{--                                   required> --}}
{{--                        </div> --}}
{{--                    </div> --}}
{{--                    <div class="modal-footer justify-content-between"> --}}
{{--                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button> --}}
{{--                        <button type="submit" class="btn btn-primary">حفظ</button> --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--            </form> --}}
{{--        </div> --}}
{{--    </div> --}}
{{--    @include('admin.orders.procurement_officer.modals.print_order_modal') --}}
{{-- @endsection() --}}

{{-- @section('script') --}}
{{--    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script> --}}
{{--    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script> --}}
{{--    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script> --}}
{{--    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script> --}}
{{--    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script> --}}
{{--    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script> --}}
{{--    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script> --}}
{{--    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script> --}}
{{--    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script> --}}
{{--    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script> --}}
{{--    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script> --}}
{{--    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script> --}}


{{--    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script> --}}

{{--    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script> --}}

{{--    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}

{{--    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script> --}}

{{--    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script> --}}

{{--    <script src="{{ asset('assets/dist/js/demo.js') }}"></script> --}}



{{--    <script> --}}
{{--        function getReferenceNumber(id) { --}}
{{--            document.getElementById('order_id').value = id; --}}
{{--            // document.getElementById('reference_number').value = reference_number; --}}
{{--            var csrfToken = $('meta[name="csrf-token"]').attr('content'); --}}
{{--            var headers = { --}}
{{--                "X-CSRF-Token": csrfToken --}}
{{--            }; --}}
{{--            $.ajax({ --}}
{{--                url: '{{ route('orders.procurement_officer.getReferenceNumber') }}', --}}
{{--                method: 'get', --}}
{{--                data: { --}}
{{--                    'order_id': id --}}
{{--                }, --}}
{{--                headers: headers, --}}
{{--                success: function (data) { --}}
{{--                    console.log(data.reference_number); --}}
{{--                    document.getElementById('reference_number_value').value = data.reference_number; --}}
{{--                    // console.log(data.reference_number); --}}
{{--                    // toastr.success('تم تعديل الحالة بنجاح') --}}
{{--                }, --}}
{{--                error: function (jqXHR, textStatus, errorThrown) { --}}
{{--                    alert('error'); --}}
{{--                } --}}
{{--            }); --}}

{{--        } --}}

{{--        function updateStatus(id) { --}}
{{--            var csrfToken = $('meta[name="csrf-token"]').attr('content'); --}}
{{--            var headers = { --}}
{{--                "X-CSRF-Token": csrfToken --}}
{{--            }; --}}
{{--            $.ajax({ --}}
{{--                url: '{{ url('users/updateStatus') }}', --}}
{{--                method: 'post', --}}
{{--                headers: headers, --}}
{{--                data: { --}}
{{--                    'id': id, --}}
{{--                    'user_status': document.getElementById('customSwitch' + id).checked --}}
{{--                }, --}}
{{--                success: function (data) { --}}
{{--                    toastr.success('تم تعديل الحالة بنجاح') --}}
{{--                }, --}}
{{--                error: function (jqXHR, textStatus, errorThrown) { --}}
{{--                    alert('error'); --}}
{{--                } --}}
{{--            }); --}}
{{--        } --}}
{{--        window.addEventListener("load", getOrderTable()); --}}
{{--        // $(document).ready(function () { --}}
{{--        //     // showLoader(); --}}
{{--        //     getOrderTable(); --}}
{{--        // }); --}}
{{--        function getOrderTable(page) { --}}
{{--            var csrfToken = $('meta[name="csrf-token"]').attr('content'); --}}
{{--            $.ajaxSetup({headers: {'X-CSRF-TOKEN': csrfToken}}); --}}
{{--            document.getElementById('order_table').innerHTML = '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>'; --}}
{{--            $.ajax({ --}}
{{--                url: '{{ url('users/procurement_officer/orders/order_table') }}', --}}
{{--                method: 'post', --}}
{{--                data: { --}}
{{--                    'search_order_number': document.getElementById('search_order_number').value, --}}
{{--                    'reference_number': document.getElementById('reference_number').value, --}}
{{--                    'order_status': document.getElementById('order_status').value, --}}
{{--                    'supplier_id': document.getElementById('supplier_id').value, --}}
{{--                    'user_category': document.getElementById('user_category').value, --}}
{{--                    'to_user': document.getElementById('to_user').value, --}}
{{--                    'from': document.getElementById('from').value, --}}
{{--                    'to': document.getElementById('to').value, --}}
{{--                    'page': page --}}
{{--                }, --}}
{{--                success: function (data) { --}}
{{--                    console.log(data); --}}
{{--                    $('#order_table').html(data); --}}
{{--                }, --}}
{{--                error: function (jqXHR, textStatus, errorThrown) { --}}
{{--                    alert(errorThrown); --}}
{{--                }, --}}
{{--                complete: function () { --}}
{{--                    // إخفاء شاشة التحميل بعد انتهاء استدعاء البيانات --}}
{{--                    hideLoader(); --}}
{{--                } --}}
{{--            }); --}}
{{--        } --}}

{{--        function updateOrderStatus(order_id,order_status_id,background_color,text_color) { --}}
{{--            console.log(order_id); --}}
{{--            var csrfToken = $('meta[name="csrf-token"]').attr('content'); --}}
{{--            $.ajaxSetup({headers: {'X-CSRF-TOKEN': csrfToken}}); --}}

{{--            $.ajax({ --}}
{{--                url: '{{ route('orders.procurement_officer.updateOrderStatus') }}', --}}
{{--                method: 'post', --}}
{{--                data: { --}}
{{--                    order_id:order_id, --}}
{{--                    order_status_id:order_status_id --}}
{{--                }, --}}
{{--                success: function (data) { --}}
{{--                    console.log(data.order_status_color.status_text_color); --}}
{{--                    var order_select = document.getElementById('order_status_'+order_id); --}}
{{--                    if(data.order_status_color.status_color == '' && data.order_status_color.status_text_color == ''){ --}}
{{--                        order_select.style.backgroundColor = '#FFFFFF'; --}}
{{--                        order_select.style.color = '#000000'; --}}
{{--                    } --}}
{{--                    else{ --}}
{{--                        order_select.style.backgroundColor = data.order_status_color.status_color; --}}
{{--                        order_select.style.color = data.order_status_color.status_text_color; --}}
{{--                    } --}}
{{--                    toastr.success('تم تعديل حالة الطلبية بنجاح'); --}}
{{--                    // order_select.style.backgroundColor = data.order_status_color.status_color; --}}
{{--                    // order_select.style.color = data.order_status_color.status_text_color; --}}
{{--                }, --}}
{{--                error: function (jqXHR, textStatus, errorThrown) { --}}
{{--                    alert(errorThrown); --}}
{{--                }, --}}
{{--            }); --}}
{{--        } --}}

{{--        function showDueDate(id){ --}}
{{--            document.getElementById('order_id_due_date').value = id; --}}
{{--            // document.getElementById('reference_number').value = reference_number; --}}
{{--            var csrfToken = $('meta[name="csrf-token"]').attr('content'); --}}
{{--            var headers = { --}}
{{--                "X-CSRF-Token": csrfToken --}}
{{--            }; --}}
{{--            $.ajax({ --}}
{{--                url: '{{ route('orders.procurement_officer.show_due_date') }}', --}}
{{--                method: 'get', --}}
{{--                data: { --}}
{{--                    'order_id': id --}}
{{--                }, --}}
{{--                headers: headers, --}}
{{--                success: function (data) { --}}
{{--                    console.log(data.reference_number); --}}
{{--                    document.getElementById('due_date_value').value = data.inserted_at; --}}
{{--                    // console.log(data.reference_number); --}}
{{--                    // toastr.success('تم تعديل الحالة بنجاح') --}}
{{--                }, --}}
{{--                error: function (jqXHR, textStatus, errorThrown) { --}}
{{--                    alert('error'); --}}
{{--                } --}}
{{--            }); --}}
{{--        } --}}

{{--        function updateToUser(id,to_user){ --}}
{{--            var csrfToken = $('meta[name="csrf-token"]').attr('content'); --}}
{{--            var headers = { --}}
{{--                "X-CSRF-Token": csrfToken --}}
{{--            }; --}}
{{--            $.ajax({ --}}
{{--                url: '{{ route('orders.procurement_officer.updateToUser') }}', --}}
{{--                method: 'post', --}}
{{--                data: { --}}
{{--                    'order_id': id, --}}
{{--                    'to_user': to_user --}}
{{--                }, --}}
{{--                headers: headers, --}}
{{--                success: function (data) { --}}
{{--                    console.log(data.reference_number); --}}
{{--                    toastr.success('تم تعديل متابعة بواسطة بنجاح'); --}}
{{--                }, --}}
{{--                error: function (jqXHR, textStatus, errorThrown) { --}}
{{--                    alert('error'); --}}
{{--                } --}}
{{--            }); --}}
{{--        } --}}

{{--        function update_shipping_status(id,status){ --}}
{{--            var csrfToken = $('meta[name="csrf-token"]').attr('content'); --}}
{{--            var headers = { --}}
{{--                "X-CSRF-Token": csrfToken --}}
{{--            }; --}}
{{--            $.ajax({ --}}
{{--                url: '{{ route('procurement_officer.orders.shipping.update_shipping_status') }}', --}}
{{--                method: 'post', --}}
{{--                data: { --}}
{{--                    'order_id': id, --}}
{{--                    'to_user': to_user --}}
{{--                }, --}}
{{--                headers: headers, --}}
{{--                success: function (data) { --}}
{{--                    console.log(data.reference_number); --}}
{{--                    toastr.success('تم تعديل متابعة بواسطة بنجاح'); --}}
{{--                }, --}}
{{--                error: function (jqXHR, textStatus, errorThrown) { --}}
{{--                    alert('error'); --}}
{{--                } --}}
{{--            }); --}}
{{--        } --}}

{{--        function PrintOrderPDF() { --}}
{{--            $('#PrintOrderPdfModal').modal('show'); --}}
{{--            $('#supplier_id_input').val(); --}}
{{--            $('#reference_number_input').val(); --}}
{{--            $('#from_input').val(); --}}
{{--            $('#to_input').val(); --}}
{{--            $('#to_user_input').val(); --}}
{{--            $('#user_category_input').val(); --}}
{{--        } --}}

{{--        var page = 1; --}}
{{--        $(document).on('click', '.pagination a', function(e) { --}}
{{--            e.preventDefault(); --}}
{{--            page = $(this).attr('href').split('page=')[1]; --}}

{{--            getOrderTable(page); --}}
{{--        }); --}}

{{--        function showLoader() { --}}
{{--            $('#loaderContainer').show(); --}}
{{--        } --}}

{{--        // دالة لإخفاء شاشة التحميل --}}
{{--        function hideLoader() { --}}
{{--            $('#loaderContainer').hide(); --}}
{{--        } --}}

{{--        function myFunction() { --}}
{{--            alert('load'); --}}
{{--        } --}}

{{--        function dateValidation() { --}}
{{--            var dateInputValue = document.getElementById('due_date_value').value; --}}

{{--            var dateInputObj = new Date(dateInputValue); --}}

{{--            // Get the current date --}}
{{--            var dateNow = new Date(); --}}

{{--            // Compare dateInputObj to dateNow --}}
{{--            if (dateInputObj > dateNow) { --}}
{{--                // If date_request is greater than date_now, validation fails, so prevent form submission --}}
{{--                alert("يجب ان يكون التاريخ المدخل اقل من او يساوي تاريخ اليوم"); --}}
{{--                return false; --}}
{{--            } else { --}}
{{--                // If date_request is less than or equal to date_now, validation passes, so allow form submission --}}
{{--                return true; --}}
{{--            } --}}
{{--        } --}}

{{--    </script> --}}

{{--    <script> --}}

{{--        $(function () { --}}
{{--            $("#example1").DataTable({ --}}
{{--                "responsive": true, "lengthChange": false, "autoWidth": false, --}}
{{--                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"] --}}
{{--            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)'); --}}
{{--            $('#example2').DataTable({ --}}
{{--                "paging": true, --}}
{{--                "lengthChange": false, --}}
{{--                "searching": false, --}}
{{--                "ordering": true, --}}
{{--                "info": true, --}}
{{--                "autoWidth": false, --}}
{{--                "responsive": true, --}}
{{--            }); --}}
{{--        }); --}}
{{--    </script> --}}

{{--    <script> --}}


{{--        $(function () { --}}
{{--            var Toast = Swal.mixin({ --}}
{{--                toast: true, --}}
{{--                position: 'top-end', --}}
{{--                showConfirmButton: false, --}}
{{--                timer: 3000 --}}
{{--            }); --}}

{{--            $('.swalDefaultSuccess').click(function () { --}}
{{--                Toast.fire({ --}}
{{--                    icon: 'success', --}}
{{--                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.swalDefaultInfo').click(function () { --}}
{{--                Toast.fire({ --}}
{{--                    icon: 'info', --}}
{{--                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.swalDefaultError').click(function () { --}}
{{--                Toast.fire({ --}}
{{--                    icon: 'error', --}}
{{--                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.swalDefaultWarning').click(function () { --}}
{{--                Toast.fire({ --}}
{{--                    icon: 'warning', --}}
{{--                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.swalDefaultQuestion').click(function () { --}}
{{--                Toast.fire({ --}}
{{--                    icon: 'question', --}}
{{--                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}

{{--            $('.toastrDefaultSuccess').click(function () { --}}
{{--                toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.') --}}
{{--            }); --}}
{{--            $('.toastrDefaultInfo').click(function () { --}}
{{--                toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.') --}}
{{--            }); --}}
{{--            $('.toastrDefaultError').click(function () { --}}
{{--                toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.') --}}
{{--            }); --}}
{{--            $('.toastrDefaultWarning').click(function () { --}}
{{--                toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.') --}}
{{--            }); --}}

{{--            $('.toastsDefaultDefault').click(function () { --}}
{{--                $(document).Toasts('create', { --}}
{{--                    title: 'Toast Title', --}}
{{--                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.toastsDefaultTopLeft').click(function () { --}}
{{--                $(document).Toasts('create', { --}}
{{--                    title: 'Toast Title', --}}
{{--                    position: 'topLeft', --}}
{{--                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.toastsDefaultBottomRight').click(function () { --}}
{{--                $(document).Toasts('create', { --}}
{{--                    title: 'Toast Title', --}}
{{--                    position: 'bottomRight', --}}
{{--                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.toastsDefaultBottomLeft').click(function () { --}}
{{--                $(document).Toasts('create', { --}}
{{--                    title: 'Toast Title', --}}
{{--                    position: 'bottomLeft', --}}
{{--                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.toastsDefaultAutohide').click(function () { --}}
{{--                $(document).Toasts('create', { --}}
{{--                    title: 'Toast Title', --}}
{{--                    autohide: true, --}}
{{--                    delay: 750, --}}
{{--                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.toastsDefaultNotFixed').click(function () { --}}
{{--                $(document).Toasts('create', { --}}
{{--                    title: 'Toast Title', --}}
{{--                    fixed: false, --}}
{{--                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.toastsDefaultFull').click(function () { --}}
{{--                $(document).Toasts('create', { --}}
{{--                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.', --}}
{{--                    title: 'Toast Title', --}}
{{--                    subtitle: 'Subtitle', --}}
{{--                    icon: 'fas fa-envelope fa-lg', --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.toastsDefaultFullImage').click(function () { --}}
{{--                $(document).Toasts('create', { --}}
{{--                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.', --}}
{{--                    title: 'Toast Title', --}}
{{--                    subtitle: 'Subtitle', --}}
{{--                    image: '../../dist/img/user3-128x128.jpg', --}}
{{--                    imageAlt: 'User Picture', --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.toastsDefaultSuccess').click(function () { --}}
{{--                $(document).Toasts('create', { --}}
{{--                    class: 'bg-success', --}}
{{--                    title: 'Toast Title', --}}
{{--                    subtitle: 'Subtitle', --}}
{{--                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.toastsDefaultInfo').click(function () { --}}
{{--                $(document).Toasts('create', { --}}
{{--                    class: 'bg-info', --}}
{{--                    title: 'Toast Title', --}}
{{--                    subtitle: 'Subtitle', --}}
{{--                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.toastsDefaultWarning').click(function () { --}}
{{--                $(document).Toasts('create', { --}}
{{--                    class: 'bg-warning', --}}
{{--                    title: 'Toast Title', --}}
{{--                    subtitle: 'Subtitle', --}}
{{--                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.toastsDefaultDanger').click(function () { --}}
{{--                $(document).Toasts('create', { --}}
{{--                    class: 'bg-danger', --}}
{{--                    title: 'Toast Title', --}}
{{--                    subtitle: 'Subtitle', --}}
{{--                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}
{{--            $('.toastsDefaultMaroon').click(function () { --}}
{{--                $(document).Toasts('create', { --}}
{{--                    class: 'bg-maroon', --}}
{{--                    title: 'Toast Title', --}}
{{--                    subtitle: 'Subtitle', --}}
{{--                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.' --}}
{{--                }) --}}
{{--            }); --}}
{{--        }); --}}

{{--    </script> --}}

{{--    <script> --}}
{{--        $(function () { --}}
{{--            //Initialize Select2 Elements --}}
{{--            $('.select2').select2() --}}

{{--            //Initialize Select2 Elements --}}
{{--            $('.select2bs4').select2({ --}}
{{--                theme: 'bootstrap4' --}}
{{--            }) --}}

{{--            //Datemask dd/mm/yyyy --}}
{{--            $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'}) --}}
{{--            //Datemask2 mm/dd/yyyy --}}
{{--            $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'}) --}}
{{--            //Money Euro --}}
{{--            $('[data-mask]').inputmask() --}}

{{--            //Date picker --}}
{{--            $('#reservationdate').datetimepicker({ --}}
{{--                format: 'L' --}}
{{--            }); --}}

{{--            //Date and time picker --}}
{{--            $('#reservationdatetime').datetimepicker({icons: {time: 'far fa-clock'}}); --}}

{{--            //Date range picker --}}
{{--            $('#reservation').daterangepicker() --}}
{{--            //Date range picker with time picker --}}
{{--            $('#reservationtime').daterangepicker({ --}}
{{--                timePicker: true, --}}
{{--                timePickerIncrement: 30, --}}
{{--                locale: { --}}
{{--                    format: 'MM/DD/YYYY hh:mm A' --}}
{{--                } --}}
{{--            }) --}}
{{--            //Date range as a button --}}
{{--            $('#daterange-btn').daterangepicker( --}}
{{--                { --}}
{{--                    ranges: { --}}
{{--                        'Today': [moment(), moment()], --}}
{{--                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')], --}}
{{--                        'Last 7 Days': [moment().subtract(6, 'days'), moment()], --}}
{{--                        'Last 30 Days': [moment().subtract(29, 'days'), moment()], --}}
{{--                        'This Month': [moment().startOf('month'), moment().endOf('month')], --}}
{{--                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')] --}}
{{--                    }, --}}
{{--                    startDate: moment().subtract(29, 'days'), --}}
{{--                    endDate: moment() --}}
{{--                }, --}}
{{--                function (start, end) { --}}
{{--                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY')) --}}
{{--                } --}}
{{--            ) --}}

{{--            //Timepicker --}}
{{--            $('#timepicker').datetimepicker({ --}}
{{--                format: 'LT' --}}
{{--            }) --}}

{{--            //Bootstrap Duallistbox --}}
{{--            $('.duallistbox').bootstrapDualListbox() --}}

{{--            //Colorpicker --}}
{{--            $('.my-colorpicker1').colorpicker() --}}
{{--            //color picker with addon --}}
{{--            $('.my-colorpicker2').colorpicker() --}}

{{--            $('.my-colorpicker2').on('colorpickerChange', function (event) { --}}
{{--                $('.my-colorpicker2 .fa-square').css('color', event.color.toString()); --}}
{{--            }) --}}

{{--            $("input[data-bootstrap-switch]").each(function () { --}}
{{--                $(this).bootstrapSwitch('state', $(this).prop('checked')); --}}
{{--            }) --}}

{{--        }) --}}
{{--        // BS-Stepper Init --}}
{{--        document.addEventListener('DOMContentLoaded', function () { --}}
{{--            window.stepper = new Stepper(document.querySelector('.bs-stepper')) --}}
{{--        }) --}}

{{--        // DropzoneJS Demo Code Start --}}
{{--        Dropzone.autoDiscover = false --}}

{{--        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument --}}
{{--        var previewNode = document.querySelector("#template") --}}
{{--        previewNode.id = "" --}}
{{--        var previewTemplate = previewNode.parentNode.innerHTML --}}
{{--        previewNode.parentNode.removeChild(previewNode) --}}

{{--        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone --}}
{{--            url: "/target-url", // Set the url --}}
{{--            thumbnailWidth: 80, --}}
{{--            thumbnailHeight: 80, --}}
{{--            parallelUploads: 20, --}}
{{--            previewTemplate: previewTemplate, --}}
{{--            autoQueue: false, // Make sure the files aren't queued until manually added --}}
{{--            previewsContainer: "#previews", // Define the container to display the previews --}}
{{--            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files. --}}
{{--        }) --}}

{{--        myDropzone.on("addedfile", function (file) { --}}
{{--            // Hookup the start button --}}
{{--            file.previewElement.querySelector(".start").onclick = function () { --}}
{{--                myDropzone.enqueueFile(file) --}}
{{--            } --}}
{{--        }) --}}

{{--        // Update the total progress bar --}}
{{--        myDropzone.on("totaluploadprogress", function (progress) { --}}
{{--            document.querySelector("#total-progress .progress-bar").style.width = progress + "%" --}}
{{--        }) --}}

{{--        myDropzone.on("sending", function (file) { --}}
{{--            // Show the total progress bar when upload starts --}}
{{--            document.querySelector("#total-progress").style.opacity = "1" --}}
{{--            // And disable the start button --}}
{{--            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled") --}}
{{--        }) --}}

{{--        // Hide the total progress bar when nothing's uploading anymore --}}
{{--        myDropzone.on("queuecomplete", function (progress) { --}}
{{--            document.querySelector("#total-progress").style.opacity = "0" --}}
{{--        }) --}}

{{--        // Setup the buttons for all transfers --}}
{{--        // The "add files" button doesn't need to be setup because the config --}}
{{--        // `clickable` has already been specified. --}}
{{--        document.querySelector("#actions .start").onclick = function () { --}}
{{--            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED)) --}}
{{--        } --}}
{{--        document.querySelector("#actions .cancel").onclick = function () { --}}
{{--            myDropzone.removeAllFiles(true) --}}
{{--        } --}}
{{--        // DropzoneJS Demo Code End --}}
{{--    </script> --}}

{{-- @endsection --}}


@extends('home')
@section('title')
    طلبات الشراء
@endsection
@section('header_title')
    طلبات الشراء
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    طلبات الشراء
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
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

        .inline-form .form-group {
            display: flex;
            align-items: center;
        }

        .inline-form label {
            margin-right: 10px;
            margin-bottom: 0;
        }

        .inline-form input {
            flex: 1;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /*.select2-container--default .select2-selection--single {*/
        /*    background-color: #FFA500; !* Change this to your desired color *!*/
        /*    color: #fff; !* Change this to your desired text color *!*/
        /*}*/

        /*!* Change the background color of the dropdown options *!*/
        /*.select2-results__option {*/
        /*    background-color: green; !* Change this to your desired option color *!*/
        /*}*/

        .select2-selection__rendered {
            background-color: white;
            color: black;
        }
    </style>
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')

    @if (auth()->user()->user_role != 3 && auth()->user()->user_role != 9 && auth()->user()->user_role != 11)
        <button type="button" class="btn btn-dark mb-2" data-toggle="modal" data-target="#modal-default"><span
                class="fa fa-plus"></span> طببية جديدة
        </button>
        <a href="{{ route('orders.procurement_officer.order_index') }}" class="btn btn-success mb-2">
            <span class="fa fa-list"></span> الطلبيات
        </a>
        <a href="{{ route('orders.procurement_officer.list_orders_from_storekeeper') }}" class="btn btn-info mb-2"><span
                class="fa fa-building"></span> الطلبيات الواردة من المستودع</a>
        <a href="{{ route('order_archive.index') }}" class="btn btn-warning mb-2"><span class="fa fa-building"></span>
            ارشيف الطلبات</a>
        <a href="{{ route('trash.index') }}" class="btn btn-danger mb-2">
            <span class="fa fa-trash"></span> الطلبيات المحذوفة
        </a>
        <button onclick="PrintOrderPDF()" class="float-right btn btn-dark"><span class="fa fa-print"></span> طباعة</button>
    @endif
    {{--        <form id="order_form" action="{{ route('orders.procurement_officer.create_order') }}" method="POST"> --}}
    {{--            @csrf --}}
    {{--            <input type="hidden" name="order_type" value="1"> --}}
    {{--            --}}{{--        <button type="submit" class="btn btn-primary mb-2" onclick="return confirm('هل تريد اضافة طلبية شراء جديدة؟')" >اضافة طلبية شراء</button> --}}
    {{--            <button type="submit" class="btn btn-dark mb-2">اضافة طلبية شراء</button> --}}
    {{--        </form> --}}



    {{--    <div class="pos-f-t"> --}}
    {{--        <div class="collapse" id="navbarToggleExternalContent"> --}}
    {{--            --}}
    {{--        </div> --}}
    {{--        <div class="row"> --}}
    {{--            <div class="col-md-3"> --}}
    {{--                <nav class=""> --}}
    {{--                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation"> --}}
    {{--                        <span class="btn btn-info">عرض الفلتر</span> --}}
    {{--                    </button> --}}
    {{--                </nav> --}}
    {{--            </div> --}}
    {{--        </div> --}}

    {{--    </div> --}}
    <div class="card bg-gradient-info">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">رقم المرجع</label>
                        <input onkeyup="getOrderTable()" placeholder="رقم المرجع" id="reference_number"
                            name="reference_number" class="form-control" type="text">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">المورد</label>
                        <select onchange="getOrderTable()" class="select2bs4 form-control supplier_select2"
                            name="supplier_id" id="supplier_id">
                            <option value="">جميع الموردين</option>
                            @foreach ($supplier as $key)
                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">متابعة بواسطة</label>
                        <select @if(auth()->user()->user_role == 2) disabled @endif  onchange="getOrderTable()" class="select2bs4 form-control supplier_select2" name="to_user"
                                id="to_user">
                            <option value="">جميع المستخدمين</option>
                            @foreach ($users as $key)
                                <option
                                        @if(auth()->user()->user_role == 2)
                                            value="{{ auth()->user()->id }}"
                                        {{ $key->id == auth()->user()->id ? 'selected' : '' }}
                                        @else
                                            value="{{ $key->id }}"
                                        @endif
                                >
                                    {{ $key->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">مجال العمل</label>
                        <select onchange="getOrderTable()" class="select2bs4 form-control supplier_select2"
                            name="user_category" id="user_category">
                            <option value="">جميع مجالات العمل</option>
                            @foreach ($user_category as $key)
                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">حالة الطلبية</label>
                        <select onchange="getOrderTable()" class="form-control" name="order_status" id="order_status">
                            <option value="">جميع الحالات</option>
                            @foreach ($order_status as $key)
                                @if ($key->id != 10)
                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">من تاريخ</label>
                        {{-- <input onchange="getOrderTable()" name="from" id="from" value="<?php echo date('Y-01-01'); ?>" type="text" class="form-control date_format"> --}}
                        <input onchange="getOrderTable()" name="from" id="from" value="<?php echo '2023-01-01'; ?>"
                            type="text" class="form-control date_format">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">الى تاريخ</label>
                        <input onchange="getOrderTable()" name="to" id="to" value="<?php echo date('Y-m-d'); ?>"
                            type="text" class="form-control date_format">
                    </div>
                </div>
                <div class="col-md-3">
                    {{--                    <div class="form-group"> --}}
                    {{--                        <label for="">هل هذا المورد معتمد ؟ :</label> --}}
                    {{--                        <br> --}}
                    {{--                        <div onchange="getOrderTable('')" style="display: inline" class="custom-control custom-radio"> --}}
                    {{--                            <input class="custom-control-input" type="radio" value="certified" id="customRadio1" name="customRadio" checked=""> --}}
                    {{--                            <label for="customRadio1" class="custom-control-label">نعم</label> --}}
                    {{--                        </div> --}}
                    {{--                        <div onchange="getOrderTable('')" style="display: inline" class="custom-control custom-radio"> --}}
                    {{--                            <input class="custom-control-input" value="not_supported" type="radio" id="customRadio2" name="customRadio"> --}}
                    {{--                            <label for="customRadio2" class="custom-control-label">لا</label> --}}
                    {{--                        </div> --}}
                    {{--                    </div> --}}
                    <div class="form-group">
                        <label for="">مورد معتمد</label>
                        <select onchange="getOrderTable()" class="form-control select2bs4" name=""
                            id="supplier_type">
                            <option value="">جميع الموردين</option>
                            <option value="certified">مورد معتمد</option>
                            <option value="not_supported">مورد غير معتمد</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        {{--        <div class="card-header"> --}}
        {{--            <h3 class="text-center">قائمة طلبات الشراء</h3> --}}
        {{--        </div> --}}
        <div class="">
            <input hidden class="form-control mb-2" type="text" id="search_order_number" onkeyup="getOrderTable()"
                placeholder="بحث عن رقم الفاتورة">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 mt-3">
                <div class="row text-center" id="order_table">

                </div>
            </div>
        </div>
        {{--        <div class="loader-container" id="loaderContainer" style="display: none;"> --}}
        {{--            <div class="loader"></div> <!-- دائرة الـ Loader --> --}}
        {{--        </div> --}}
    </div>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-default">
            <form onsubmit="return " action="{{ route('orders.procurement_officer.create_order') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة طلبية شراء</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>اسم المورد</label>
                            <select required class="select2bs4 select2-hidden-accessible" multiple=""
                                name="supplier[]" style="width: 100%;">
                                @foreach ($supplier as $key)
                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">الرقم المرجعي</label>
                            <input name="reference_number" value="" id="reference_number" type="text"
                                class="form-control" placeholder="الرقم المرجعي">
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
    <div class="modal fade" id="modal-reference_number">
        <div class="modal-dialog modal-default">
            <form action="{{ route('orders.procurement_officer.update_reference_number') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="order_id" name="order_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">تعديل الرقم المرجعي</h4>
                        <h4 class="modal-title">تعديل الرقم المرجعي</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>الرقم المرجعي</label>
                            <input type="text" class="form-control" name="reference_number"
                                id="reference_number_value" required>
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
    <div class="modal fade" id="modal-show_due_date">
        <div class="modal-dialog modal-default">
            <form onsubmit="return dateValidation()" action="{{ route('orders.procurement_officer.update_due_date') }}"
                method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="order_id_due_date" name="order_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">تعديل تاريخ الطلبية</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>تاريخ الطلبية</label>
                            <input type="text" class="form-control date_format" name="due_date" id="due_date_value"
                                required>
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
    @include('admin.orders.procurement_officer.modals.print_order_modal')
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

    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>



    <script>
        function getReferenceNumber(id) {
            document.getElementById('order_id').value = id;
            // document.getElementById('reference_number').value = reference_number;
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('orders.procurement_officer.getReferenceNumber') }}',
                method: 'get',
                data: {
                    'order_id': id
                },
                headers: headers,
                success: function(data) {
                    console.log(data.reference_number);
                    document.getElementById('reference_number_value').value = data.reference_number;
                    // console.log(data.reference_number);
                    // toastr.success('تم تعديل الحالة بنجاح')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });

        }

        function updateStatus(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ url('users/updateStatus') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'user_status': document.getElementById('customSwitch' + id).checked
                },
                success: function(data) {
                    toastr.success('تم تعديل الحالة بنجاح')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
        window.addEventListener("load", getOrderTable());
        // $(document).ready(function () {
        //     // showLoader();
        //     getOrderTable();
        // });
        function getOrderTable(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            document.getElementById('order_table').innerHTML =
                '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '{{ url('users/procurement_officer/orders/order_table') }}',
                method: 'post',
                data: {
                    'search_order_number': document.getElementById('search_order_number').value,
                    'reference_number': document.getElementById('reference_number').value,
                    'order_status': document.getElementById('order_status').value,
                    'supplier_id': document.getElementById('supplier_id').value,
                    'user_category': document.getElementById('user_category').value,
                    'to_user': document.getElementById('to_user').value,
                    'from': document.getElementById('from').value,
                    'to': document.getElementById('to').value,
                    // 'supplier_type': $('input[name="customRadio"]:checked').val(),
                    'supplier_type': $('#supplier_type').val(),
                    'page': page
                },
                success: function(data) {
                    console.log(data);
                    $('#order_table').html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                complete: function() {
                    // إخفاء شاشة التحميل بعد انتهاء استدعاء البيانات
                    hideLoader();
                }
            });
        }

        function updateOrderStatus(order_id, order_status_id, background_color, text_color) {
            console.log(order_id);
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            $.ajax({
                url: '{{ route('orders.procurement_officer.updateOrderStatus') }}',
                method: 'post',
                data: {
                    order_id: order_id,
                    order_status_id: order_status_id
                },
                success: function(data) {
                    console.log(data.order_status_color.status_text_color);
                    var order_select = document.getElementById('order_status_' + order_id);
                    if (data.order_status_color.status_color == '' && data.order_status_color
                        .status_text_color == '') {
                        order_select.style.backgroundColor = '#FFFFFF';
                        order_select.style.color = '#000000';
                    } else {
                        order_select.style.backgroundColor = data.order_status_color.status_color;
                        order_select.style.color = data.order_status_color.status_text_color;
                    }
                    toastr.success('تم تعديل حالة الطلبية بنجاح');
                    // order_select.style.backgroundColor = data.order_status_color.status_color;
                    // order_select.style.color = data.order_status_color.status_text_color;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
            });
        }

        function showDueDate(id) {
            document.getElementById('order_id_due_date').value = id;
            // document.getElementById('reference_number').value = reference_number;
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('orders.procurement_officer.show_due_date') }}',
                method: 'get',
                data: {
                    'order_id': id
                },
                headers: headers,
                success: function(data) {
                    console.log(data.reference_number);
                    document.getElementById('due_date_value').value = data.inserted_at;
                    // console.log(data.reference_number);
                    // toastr.success('تم تعديل الحالة بنجاح')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function updateToUser(id, to_user) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('orders.procurement_officer.updateToUser') }}',
                method: 'post',
                data: {
                    'order_id': id,
                    'to_user': to_user
                },
                headers: headers,
                success: function(data) {
                    console.log(data.reference_number);
                    toastr.success('تم تعديل متابعة بواسطة بنجاح');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_shipping_status(id, status) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('procurement_officer.orders.shipping.update_shipping_status') }}',
                method: 'post',
                data: {
                    'order_id': id,
                    'to_user': to_user
                },
                headers: headers,
                success: function(data) {
                    console.log(data.reference_number);
                    toastr.success('تم تعديل متابعة بواسطة بنجاح');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function PrintOrderPDF() {
            $('#PrintOrderPdfModal').modal('show');
            $('#supplier_id_input').val();
            $('#reference_number_input').val();
            $('#from_input').val();
            $('#to_input').val();
            $('#to_user_input').val();
            $('#user_category_input').val();
        }

        var page = 1;
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];

            getOrderTable(page);
        });

        function showLoader() {
            $('#loaderContainer').show();
        }

        // دالة لإخفاء شاشة التحميل
        function hideLoader() {
            $('#loaderContainer').hide();
        }

        function myFunction() {
            alert('load');
        }

        function dateValidation() {
            var dateInputValue = document.getElementById('due_date_value').value;

            var dateInputObj = new Date(dateInputValue);

            // Get the current date
            var dateNow = new Date();

            // Compare dateInputObj to dateNow
            if (dateInputObj > dateNow) {
                // If date_request is greater than date_now, validation fails, so prevent form submission
                alert("يجب ان يكون التاريخ المدخل اقل من او يساوي تاريخ اليوم");
                return false;
            } else {
                // If date_request is less than or equal to date_now, validation passes, so allow form submission
                return true;
            }
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

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

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
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                        'MMMM D, YYYY'))
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

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
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

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>
@endsection
