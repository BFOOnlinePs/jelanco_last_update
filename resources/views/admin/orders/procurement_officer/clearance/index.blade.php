@extends('home')
@section('title')
    التخليص
@endsection
@section('header_title')
    <span>التخليص <span>@if($order->reference_number != 0) #{{ $order->reference_number }} @endif</span></span>
@endsection
@section('header_link')
    التخليص
@endsection
@section('header_title_link')
    التخليص
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

        .image-upload > input {
            display: none;
        }

    </style>

@endsection
@section('content')

{{--    @include('admin.orders.progreesbar')--}}
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    @include('admin.orders.order_menu')


    <div class="card">

        <div class="card-header">
            <h3 class="text-center">التخليص</h3>
        </div>

        <div class="card-body">
            <button type="button" class="btn btn-dark mb-3" data-toggle="modal" data-target="#modal-lg-clearance">
                اضافة تخليص
                <span class="fa fa-plus"></span>
            </button>
            @foreach($data as $key)
                <div class="card">
                    <div class="card-header bg-warning">
                        <div class="row">
                            <div class="col-md-10">
                                <h5>{{ $key['company']->name }}</h5>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('procurement_officer.orders.clearance.delete',['id'=>$key->id]) }}" onclick="return confirm('هل تريد حذف البيانات مع العلم انه لا يمكن استرجاع البيانات ؟')" class="btn btn-danger"><span class="fa fa-trash mt-1"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 bg-info">
                                <table class="table table-sm p-0 m-0">
                                    @foreach($clearance_attachment as $child)
                                        <tr>
                                            <td class="text-center"><span
                                                    onclick="create_order_clearance_attachment({{ $key->id }},{{ $child->id }})"
                                                    class="fa fa-plus btn btn-secondary bg-white"></span></td>
                                            <td>{{ $child->type_name }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="col-md-9">
                                <div id="clearance_table_{{ $key->id }}">
                                    <table class="table table-sm p-0 m-0">
                                        <tr>
                                            <td>الرقم</td>
                                            <td>الاسم</td>
                                            <td>نسخة</td>
                                            <td>اصلية</td>
                                            <td>العمليات</td>
                                        </tr>
                                    @if(!($key['order_clearance_attachment'])->isEmpty())
                                            @foreach($key['order_clearance_attachment'] as $child)

                                                    <tr id="delete_row_{{$child->id}}">
                                                    <td>{{ $child->id }}</td>
                                                    <td>{{ $child['attachment_type']->type_name }}</td>
                                                    <td>
                                                        @if(empty($child->attachment_original))
                                                            <form
                                                                id="upload-form-{{ $child->id }}"
                                                                name="upload-form"
                                                                data-id="{{ $child->id }}"
                                                            >
                                                                <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                                                <input type="hidden" name="order_id"
                                                                       value="{{ $order->id }}">
                                                                <input type="hidden" class="id"
                                                                       name="id"
                                                                       value="{{ $child->id }}">
                                                                <input type="hidden" id="order_clearance_id_{{$child->id}}" class="order_clearance_id"
                                                                       name="order_clearance_id"
                                                                       value="{{ $child->order_clearance_id }}">
                                                                <div class="image-upload">
                                                                    <label for="file-input-{{ $child->id }}">
                                                                        <span class="fa fa-upload btn btn-dark"></span>
                                                                    </label>
                                                                    <input
                                                                           id="file-input-{{ $child->id }}"
                                                                           name="attachment_original" type="file"/>
                                                                    <button type="button" class="btn btn-success btn-sm" onclick="clearance_update({{ $child->id }},{{ $key->id }})"><span class="fa fa-save"></span></button>
                                                                </div>
                                                            </form>
                                                        @else

                                                            <a type="text"
                                                               href="{{ asset('storage/attachment/'.$child->attachment_original) }}"
                                                               download="{{ $child->attachment_original }}"
                                                               class="btn btn-primary btn-sm"><span
                                                                    class="fa fa-download"></span></a>
                                                            <button
                                                                onclick="viewAttachment({{ $child->id }},'{{ asset('storage/attachment/'.$child->attachment_original) }}',null)"
                                                                href="" class="btn btn-success btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#modal-lg-view_attachment"><span
                                                                    class="fa fa-search"></span></button>
                                                            <button onclick="update_to_null_order_clearance_attachment({{ $child->id }},'original',{{ $child->order_clearance_id }})" class="btn btn-danger btn-sm"><span
                                                                    class="fa fa-trash"></span></button>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(empty($child->attachment_copy))
                                                            <form
                                                                id="upload-form-copy-{{ $child->id }}"
                                                                name="upload-form-copy"
                                                                data-id="{{ $child->id }}"
                                                            >
                                                                <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                                                <input type="hidden" name="order_id"
                                                                       value="{{ $order->id }}">
                                                                <input type="hidden" class="id"
                                                                       name="id"
                                                                       value="{{ $child->id }}">
                                                                <input type="hidden" id="order_clearance_id_{{$child->id}}" class="order_clearance_id"
                                                                       name="order_clearance_id"
                                                                       value="{{ $child->order_clearance_id }}">
                                                                <div class="image-upload">
                                                                    <label for="file-input-copy-{{ $child->id }}">
                                                                        <span class="fa fa-upload btn btn-dark"></span>
                                                                    </label>
                                                                    <input
                                                                        id="file-input-copy-{{ $child->id }}"
                                                                        name="attachment_copy" type="file"/>
                                                                    <button type="button" class="btn btn-success btn-sm" onclick="clearance_update_copy({{ $child->id }},{{ $key->id }})"><span class="fa fa-save"></span></button>
                                                                </div>
                                                            </form>
                                                        @else
                                                            <a type="text"
                                                               href="{{ asset('storage/attachment/'.$child->attachment_copy) }}"
                                                               download="{{ $child->attachment_copy }}"
                                                               class="btn btn-primary btn-sm"><span
                                                                    class="fa fa-download"></span></a>
                                                            <button
                                                                onclick="viewAttachment({{ $child->id }},'{{ asset('storage/attachment/'.$child->attachment_copy) }}',null)"
                                                                href="" class="btn btn-success btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#modal-lg-view_attachment"><span
                                                                    class="fa fa-search"></span></button>
                                                            <button onclick="update_to_null_order_clearance_attachment({{ $child->id }},'copy',{{ $child->order_clearance_id }})" class="btn btn-danger btn-sm"><span
                                                                    class="fa fa-trash"></span></button>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button onclick="delete_order_clearance_attachment({{ $child->id }},{{$child->order_clearance_id}})" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row m-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الحالة</label>
                                <select onchange="clearance_status({{ $key->id }},this.value)" class="form-control" name="status" id="">
                                    <option @if($key->status == 1) selected @endif value="1">قيد المتابعة</option>
                                    <option @if($key->status == 2) selected @endif value="2">تم دفع الملف الجمركي</option>
                                    <option @if($key->status == 3) selected @endif value="3">فحص امني</option>
                                    <option @if($key->status == 4) selected @endif value="4">خروج</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row m-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الملاحظات</label>
                                <textarea onchange="clearance_notes({{ $key->id }},this.value)" class="form-control" name="" id="" cols="30" rows="3">{{ $key->notes }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal fade" id="modal-lg-clearance">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('procurement_officer.orders.clearance.create') }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة شركة تخليص</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">شركة التخليص</label>
                                    <select required class="form-control select2bs4" name="order_clearance_company_id"
                                            id="">
                                        <option value="" selected>اختر شركة تخليص ...</option>
                                        @foreach($users as $key)
                                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">الملاحظات</label>
                                    <textarea placeholder="يرجى كتابة الملاحظات" class="form-control" name="notes" id=""
                                              cols="30" rows="3"></textarea>
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

        // window.onload = function () {
        //     get_clearance_table();
        // }

        function get_order_clearance_id(order_clearance_id) {
            // alert('order_clearance_id: ' + order_clearance_id);
            // You can set the order_clearance_id value in the respective form field
            document.getElementById('order_clearance_id_'+order_clearance_id).value = order_clearance_id;
        }

        function create_order_clearance_attachment(order_clearance_id, attachment_type) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': csrfToken}});
            document.getElementById('clearance_table_' + order_clearance_id).innerHTML = 'جاري التحميل ...';
            $.ajax({
                url: '{{ route('procurement_officer.orders.clearance.create_order_clearance_attachment') }}',
                method: 'post',
                data: {
                    'order_clearance_id': order_clearance_id,
                    'attachment_type': attachment_type,
                    'order_id':{{$order->id}}
                },
                success: function (data) {
                    document.getElementById('clearance_table_' + order_clearance_id).innerHTML = data;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                complete: function () {
                    // إخفاء شاشة التحميل بعد انتهاء استدعاء البيانات
                    // hideLoader();
                }
            });
        }

        function clearance_update(childId,index) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });
            // Correctly identify the form by its ID
            var formData = new FormData(document.getElementById('upload-form-' + childId));

            $.ajax({
                url: '{{ route('procurement_officer.orders.clearance.update') }}',
                method: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    // Handle the response data here
                    console.log(data);
                    $('#clearance_table_'+index).html(data);
                    // Optionally, update the page based on the response
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Handle errors
                    alert(errorThrown);
                },
                complete: function () {
                    // Additional actions after the request is complete
                }
            });

            return false; // Prevent the default form submission
        }
        function clearance_update_copy(childId,index) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });
            // Correctly identify the form by its ID
            var formData = new FormData(document.getElementById('upload-form-copy-' + childId));

            $.ajax({
                url: '{{ route('procurement_officer.orders.clearance.update') }}',
                method: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    // Handle the response data here
                    console.log(data);
                    $('#clearance_table_'+index).html(data);
                    // Optionally, update the page based on the response
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Handle errors
                    alert(errorThrown);
                },
                complete: function () {
                    // Additional actions after the request is complete
                }
            });

            return false; // Prevent the default form submission
        }
        function clearance_status(id,status) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });
            // Correctly identify the form by its ID

            $.ajax({
                url: '{{ route('procurement_officer.orders.clearance.clearance_status') }}',
                method: 'post',
                data: {
                    'id':id,
                    'status':status
                },
                success: function (data) {
                    // Handle the response data here
                    console.log(data);
                    toastr.success('تم تعديل الحالة بنجاح')
                    // Optionally, update the page based on the response
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Handle errors
                    alert(errorThrown);
                },
                complete: function () {
                    // Additional actions after the request is complete
                }
            });

            return false; // Prevent the default form submission
        }
        function clearance_notes(id,notes) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });
            // Correctly identify the form by its ID

            $.ajax({
                url: '{{ route('procurement_officer.orders.clearance.clearance_notes') }}',
                method: 'post',
                data: {
                    'id':id,
                    'notes':notes
                },
                success: function (data) {
                    // Handle the response data here
                    console.log(data);
                    toastr.success('تم تعديل الملاحظة بنجاح بنجاح')
                    // Optionally, update the page based on the response
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Handle errors
                    alert(errorThrown);
                },
                complete: function () {
                    // Additional actions after the request is complete
                }
            });

            return false; // Prevent the default form submission
        }

    </script>

    <script>
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
                success: function (data) {
                    toastr.success('تم تعديل الحالة بنجاح')
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        $(document).ready(function () {
            getOrderTable();
        });

        function getOrderTable() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': csrfToken}});

            $.ajax({
                url: '{{ url('users/procurement_officer/orders/order_table') }}',
                method: 'post',
                data: {
                    'search_order_number': document.getElementById('search_order_number').value
                },
                success: function (data) {
                    $('#order_table').html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                complete: function () {
                    // إخفاء شاشة التحميل بعد انتهاء استدعاء البيانات
                    hideLoader();
                }
            });
        }

        function delete_order_clearance_attachment(id,order_clearance_id) {
            if(confirm('هل تريد حذف البيانات علما انه لا يمكن استرجاع البيانات ؟')){
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': csrfToken}});

                $.ajax({
                    url: '{{ route("procurement_officer.orders.clearance.delete_order_clearance_attachment") }}',
                    method: 'post',
                    data: {
                        'id': id,
                        'order_clearance_id':order_clearance_id
                    },
                    success: function (data) {
                        console.log(data);
                        if(data.success == 'true'){
                            $('#delete_row_'+id).remove();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(errorThrown);
                    },
                    complete: function () {
                        // إخفاء شاشة التحميل بعد انتهاء استدعاء البيانات
                    }
                });
            }
        }

        function update_to_null_order_clearance_attachment(id,type,order_clearance_id,index) {
            if(confirm('هل تريد حذف البيانات علما انه لا يمكن استرجاع البيانات ؟')){
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': csrfToken}});

                $.ajax({
                    url: '{{ route("procurement_officer.orders.clearance.update_to_null_order_clearance_attachment") }}',
                    method: 'post',
                    data: {
                        'id': id,
                        'type':type,
                        'order_clearance_id':order_clearance_id,
                        'order_id':{{ $order->id }}
                    },
                    success: function (data) {
                        $('#clearance_table_'+order_clearance_id).html(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(errorThrown);
                    },
                    complete: function () {
                        // إخفاء شاشة التحميل بعد انتهاء استدعاء البيانات
                    }
                });
            }
        }
        // window.onload = getOrderTable();
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

