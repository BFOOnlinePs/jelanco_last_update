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
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

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
        <button type="button" class="btn btn-dark mb-2" data-toggle="modal" data-target="#modal-default">
            <span class="fa fa-plus"></span> طلبية جديدة
        </button>
        <a href="{{ route('orders.procurement_officer.order_index') }}" class="btn btn-success mb-2">
            <span class="fa fa-list"></span> الطلبيات
        </a>
        <a href="{{ route('orders.procurement_officer.list_orders_from_storekeeper') }}" class="btn btn-info mb-2">
            <span class="fa fa-building"></span> الطلبيات الواردة من المستودع
        </a>
        <a href="{{ route('order_archive.index') }}" class="btn btn-warning mb-2">
            <span class="fa fa-building"></span> ارشيف الطلبات
        </a>
        <a href="{{ route('trash.index') }}" class="btn btn-danger mb-2">
            <span class="fa fa-trash"></span> الطلبيات المحذوفة
        </a>
        <button onclick="PrintOrderPDF()" class="float-right btn btn-dark"><span class="fa fa-print"></span> طباعة</button>
    @endif

    <div class="card bg-gradient-info">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>رقم المرجع</label>
                        <input onkeyup="getOrderTable()" placeholder="رقم المرجع" id="reference_number" name="reference_number" class="form-control" type="text">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>المورد</label>
                        <select onchange="getOrderTable()" class="select2bs4 form-control supplier_select2" name="supplier_id" id="supplier_id">
                            <option value="">جميع الموردين</option>
                            @foreach ($supplier as $key)
                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>متابعة بواسطة</label>
                        <select @if (auth()->user()->user_role == 2) disabled @endif onchange="getOrderTable()" class="select2bs4 form-control supplier_select2" name="to_user" id="to_user">
                            <option value="">جميع المستخدمين</option>
                            @foreach ($users as $key)
                                <option @if (auth()->user()->user_role == 2) value="{{ auth()->user()->id }}" {{ $key->id == auth()->user()->id ? 'selected' : '' }} @else value="{{ $key->id }}" @endif>
                                    {{ $key->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>مجال العمل</label>
                        <select onchange="getOrderTable()" class="select2bs4 form-control supplier_select2" name="user_category" id="user_category">
                            <option value="">جميع مجالات العمل</option>
                            @foreach ($user_category as $key)
                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>حالة الطلبية</label>
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
                        <label>من تاريخ</label>
                        <input onchange="getOrderTable()" name="from" id="from" value="<?php echo '2023-01-01'; ?>" type="text" class="form-control date_format">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>الى تاريخ</label>
                        <input onchange="getOrderTable()" name="to" id="to" value="<?php echo date('Y-m-d'); ?>" type="text" class="form-control date_format">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>مورد معتمد</label>
                        <select onchange="getOrderTable()" class="form-control select2bs4" id="supplier_type">
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
        <div class="">
            <input hidden class="form-control mb-2" type="text" id="search_order_number" onkeyup="getOrderTable()" placeholder="بحث عن رقم الفاتورة">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 mt-3">
                <div class="row text-center" id="order_table">
                    </div>
            </div>
        </div>
        <div class="loader-container" id="loaderContainer" style="display: none;">
            <div class="loader"></div>
        </div>
    </div>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-default">
            <form onsubmit="return " action="{{ route('orders.procurement_officer.create_order') }}" method="post" enctype="multipart/form-data">
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
                            <select required class="select2bs4 select2-hidden-accessible" multiple="" name="supplier[]" style="width: 100%;">
                                @foreach ($supplier as $key)
                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>الرقم المرجعي</label>
                            <input name="reference_number" value="" id="reference_number" type="text" class="form-control" placeholder="الرقم المرجعي">
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
            <form action="{{ route('orders.procurement_officer.update_reference_number') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="order_id" name="order_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">تعديل الرقم المرجعي</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>الرقم المرجعي</label>
                            <input type="text" class="form-control" name="reference_number" id="reference_number_value" required>
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
            <form onsubmit="return dateValidation()" action="{{ route('orders.procurement_officer.update_due_date') }}" method="post" enctype="multipart/form-data">
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
                            <input type="text" class="form-control date_format" name="due_date" id="due_date_value" required>
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

    <div class="modal fade" id="modal-order-comments">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">سجل ملاحظات الطلبية</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="comment_order_id">
                    <div class="comments-container mb-3" style="background: #f4f6f9; padding: 15px; border-radius: 5px; height: 300px; overflow-y: auto; border: 1px solid #ddd;">
                        <div id="comments_history">
                            <div class="text-center text-muted mt-5"><i class="fas fa-spinner fa-spin"></i> جاري التحميل...</div>
                        </div>
                    </div>
                    <label>إضافة ملاحظة جديدة:</label>
                    <div class="input-group">
                        <textarea id="new_comment_text" class="form-control" rows="2" placeholder="اكتب ملاحظتك هنا..."></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button" onclick="saveOrderComment()">
                                <i class="fas fa-paper-plane"></i> إرسال
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.orders.procurement_officer.modals.print_order_modal')
    @include('admin.orders.procurement_officer.modals.add_new_date')
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
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>

    <script>
        // تشغيل الجدول عند تحميل الصفحة
        $(document).ready(function() {
            getOrderTable();
            $('[data-toggle="tooltip"]').tooltip();
            
            // تهيئة مكتبات التاريخ والـ Select2
            $('.select2').select2();
            $('.select2bs4').select2({ theme: 'bootstrap4' });
            $('#reservationdate').datetimepicker({ format: 'L' });
        });

        function getReferenceNumber(id) {
            document.getElementById('order_id').value = id;
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = { "X-CSRF-Token": csrfToken };
            $.ajax({
                url: "{{ route('orders.procurement_officer.getReferenceNumber') }}",
                method: 'get',
                data: { 'order_id': id },
                headers: headers,
                success: function(data) {
                    document.getElementById('reference_number_value').value = data.reference_number;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function updateStatus(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = { "X-CSRF-Token": csrfToken };
            $.ajax({
                url: "{{ url('users/updateStatus') }}",
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

        function getOrderTable(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });
            
            // عرض أيقونة التحميل
            $('#order_table').html('<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>');
            
            $.ajax({
                url: "{{ url('users/procurement_officer/orders/order_table') }}",
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
                    'supplier_type': $('#supplier_type').val(),
                    'page': page
                },
                success: function(data) {
                    $('#order_table').html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                complete: function() {
                    hideLoader();
                }
            });
        }

        function updateOrderStatus(order_id, order_status_id, background_color, text_color) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });

            $.ajax({
                url: "{{ route('orders.procurement_officer.updateOrderStatus') }}",
                method: 'post',
                data: {
                    order_id: order_id,
                    order_status_id: order_status_id
                },
                success: function(data) {
                    var order_select = document.getElementById('order_status_' + order_id);
                    if (data.order_status_color.status_color == '' && data.order_status_color.status_text_color == '') {
                        order_select.style.backgroundColor = '#FFFFFF';
                        order_select.style.color = '#000000';
                    } else {
                        order_select.style.backgroundColor = data.order_status_color.status_color;
                        order_select.style.color = data.order_status_color.status_text_color;
                    }
                    toastr.success('تم تعديل حالة الطلبية بنجاح');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
            });
        }

        function showDueDate(id) {
            document.getElementById('order_id_due_date').value = id;
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = { "X-CSRF-Token": csrfToken };
            $.ajax({
                url: "{{ route('orders.procurement_officer.show_due_date') }}",
                method: 'get',
                data: { 'order_id': id },
                headers: headers,
                success: function(data) {
                    document.getElementById('due_date_value').value = data.inserted_at;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function updateToUser(id, to_user) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = { "X-CSRF-Token": csrfToken };
            $.ajax({
                url: "{{ route('orders.procurement_officer.updateToUser') }}",
                method: 'post',
                data: {
                    'order_id': id,
                    'to_user': to_user
                },
                headers: headers,
                success: function(data) {
                    toastr.success('تم تعديل متابعة بواسطة بنجاح');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        // ======================= دوال الملاحظات (الجديدة) =======================
        function openStorekeeperNotesModal(id) {
            $('#comment_order_id').val(id);
            $('#new_comment_text').val('');
            $('#modal-order-comments').modal('show');
            loadComments(id);
            // إخفاء مؤشر الرسائل الجديدة عند فتح المودال وتحديث لون الزر
            $('#order_table button[onclick="openStorekeeperNotesModal(' + id + ')"]')
                .removeClass('btn-danger')
                .addClass('btn-outline-secondary')
                .find('.badge').remove();
        }

        function loadComments(id) {
            $('#comments_history').html('<div class="text-center text-muted mt-5"><i class="fas fa-spinner fa-spin"></i> جاري التحميل...</div>');

            $.ajax({
                url: "{{ route('orders.comments.get') }}",
                type: "GET",
                data: { order_id: id },
                success: function(comments) {
                    var html = '';
                    if(comments.length > 0) {
                        comments.forEach(function(comment) {
                            var date = new Date(comment.created_at).toLocaleString('en-GB');
                            var isMe = comment.user_id == "{{ auth()->id() }}";
                            var bgClass = isMe ? 'alert-info' : 'alert-secondary';
                            
                            html += `
                                <div class="comment-item mb-2 p-2 rounded ${bgClass}">
                                    <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                                        <strong style="font-size:13px;">
                                            <i class="fas fa-user-circle"></i> ${comment.user.name}
                                        </strong>
                                        <small class="text-dark" style="font-size:11px;">${date}</small>
                                    </div>
                                    <p class="mb-0" style="font-size:14px; white-space: pre-wrap;">${comment.comment}</p>
                                    ${isMe ? 
                                        (comment.is_seen ? '<div class="text-right mt-1"><i class="fas fa-check-double text-primary" title="مقروءة" style="font-size:12px;"></i> <span style="font-size:10px;">مقروءة</span></div>' : '<div class="text-right mt-1"><i class="fas fa-check text-secondary" title="غير مقروءة" style="font-size:12px;"></i> <span style="font-size:10px;">غير مقروءة</span></div>') 
                                        : ''}
                                </div>
                            `;
                        });
                    } else {
                        html = '<div class="text-center text-muted mt-5">لا توجد ملاحظات سابقة، كن أول من يكتب!</div>';
                    }
                    $('#comments_history').html(html);
                },
                error: function() {
                    $('#comments_history').html('<p class="text-danger text-center">حدث خطأ في جلب البيانات</p>');
                }
            });
        }

        function saveOrderComment() {
            var id = $('#comment_order_id').val();
            var comment = $('#new_comment_text').val();
            
            if(!comment.trim()) {
                toastr.warning('الرجاء كتابة نص الملاحظة');
                return;
            }

            var btn = event.target;
            $(btn).prop('disabled', true);

            $.ajax({
                url: "{{ route('orders.comments.create') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order_id: id,
                    comment: comment
                },
                success: function(response) {
                    $(btn).prop('disabled', false);
                    if(response.success) {
                        toastr.success('تمت الإضافة');
                        $('#new_comment_text').val('');
                        loadComments(id);
                    }
                },
                error: function() {
                    $(btn).prop('disabled', false);
                    toastr.error('فشل الحفظ');
                }
            });
        }
        // ======================= نهاية دوال الملاحظات =======================

        function update_shipping_status(id, status) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = { "X-CSRF-Token": csrfToken };
            $.ajax({
                url: "{{ route('procurement_officer.orders.shipping.update_shipping_status') }}",
                method: 'post',
                data: {
                    'order_id': id,
                    // ملاحظة: تأكد من أن to_user معرف أو مرر القيمة الصحيحة
                    'to_user': document.getElementById('to_user').value 
                },
                headers: headers,
                success: function(data) {
                    toastr.success('تم تعديل حالة الشحن');
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

        $('#ajaxDateForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize();

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#AddNewDate').modal('hide');
                        var newHtml = `
                            <span class="badge badge-warning text-dark" style="font-size: 11px;">
                                ${response.new_date}
                            </span>
                            <a href="javascript:void(0)"
                               data-toggle="modal"
                               data-target="#AddNewDate"
                               onclick="setOrderIdForDate(${response.order_id})"
                               title="تعديل التاريخ"
                               class="text-dark ml-1">
                                <i class="fa fa-edit" style="font-size: 10px;"></i>
                            </a>
                        `;
                        $('#date_container_' + response.order_id).html(newHtml);
                    } else {
                        alert('حدث خطأ أثناء الحفظ');
                    }
                },
                error: function() {
                    alert('خطأ في الاتصال بالسيرفر');
                }
            });
        });

        function setOrderIdForDate(id) {
            $('#modal_order_id').val(id);
            $('#new_date').val('');
            $('#AddNewDate').modal('show');
        }

        var page = 1;
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            getOrderTable(page);
        });

        function showLoader() { $('#loaderContainer').show(); }
        function hideLoader() { $('#loaderContainer').hide(); }

        function dateValidation() {
            var dateInputValue = document.getElementById('due_date_value').value;
            var dateInputObj = new Date(dateInputValue);
            var dateNow = new Date();
            if (dateInputObj > dateNow) {
                alert("يجب ان يكون التاريخ المدخل اقل من او يساوي تاريخ اليوم");
                return false;
            } else {
                return true;
            }
        }
    </script>
@endsection