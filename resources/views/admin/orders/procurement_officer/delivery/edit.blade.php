@extends('home')
@section('title')
    التوصيل
@endsection
@section('header_title')
    <span>التوصيل <span>@if($order->reference_number != 0) #{{ $order->reference_number }} @endif</span></span>
@endsection
@section('header_link')
    طلبات الشراء
@endsection
@section('header_title_link')
    التوصيل
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

@endsection
@section('content')

{{--    @include('admin.orders.progreesbar')--}}
    <div class="card">
        <div class="card-body">
            <form action="{{ route('procurement_officer.orders.delivery.update') }}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="row">
                <input type="hidden" name="id" value="{{ $data->id }}">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">شركة التوصيل</label>
                            <select required name="delivery_company_id" class="form-control select2bs4" id="">
                                <option value="">يرجى اختيار شركة توصيل</option>
                                @foreach ($delivery_company as $key)
                                    <option @if($key->id == $data->delivery_company_id) selected @endif value="{{ $key->id }}">{{ $key->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">المرفقات</label>
                            @if(!empty($data->attachment))
                                        <a type="text"
                                           href="{{ asset('storage/attachment/'.$data->attachment) }}"
                                           download="{{ $data->attachment }}" class="btn btn-primary btn-sm"><span
                                                class="fa fa-download"></span></a>
                                        <button
                                            onclick="viewAttachment({{ $data->id }},'{{ asset('storage/attachment/'.$data->attachment) }}',null)"
                                            href="" class="btn btn-success btn-sm" data-toggle="modal"
                                            data-target="#modal-lg-view_attachment"><span
                                                class="fa fa-search"></span></button>
                                    @endif
                            <br>
                            <input type="file" class="form-control" name="attachment">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for=""></label>
                            <textarea class="form-control" name="notes" id="" cols="30" rows="3">{{ $data->notes }}</textarea>
                        </div>
                    </div>
                <button class="btn btn-success" type="submit">حفظ التعديلات <span class="fa fa-edit"></span></button>
            </div>
        </form>

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
        {{--function get_table_order_local_delivery_items(order_local_delivery_id) {--}}
        {{--    var csrfToken = $('meta[name="csrf-token"]').attr('content');--}}
        {{--    var headers = {--}}
        {{--        "X-CSRF-Token": csrfToken--}}
        {{--    };--}}
        {{--    $.ajax({--}}
        {{--        url: '{{ route('procurement_officer.orders.delivery.get_table_order_local_delivery_items') }}',--}}
        {{--        method: 'post',--}}
        {{--        headers: headers,--}}
        {{--        data: {--}}
        {{--            'order_delivery_id': order_local_delivery_id--}}
        {{--        },--}}
        {{--        success: function (data) {--}}
        {{--            $('#delivery_table_' + order_local_delivery_id).html(data);--}}
        {{--        },--}}
        {{--        error: function (jqXHR, textStatus, errorThrown) {--}}
        {{--            alert('error');--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}

        function create_order_local_delivery_items(order_local_delivery_id, estimation_cost_element_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('delivery_table_' + order_local_delivery_id).innerText = 'جاري التحميل ...'
            $.ajax({
                url: '{{ route('procurement_officer.orders.delivery.create_order_local_delivery_items') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_local_delivery_id': order_local_delivery_id,
                    'estimation_cost_element_id': estimation_cost_element_id
                },
                success: function (data) {
                    if (data.success == 'true') {
                        $('#delivery_table_' + order_local_delivery_id).html(data.view);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function delete_order_local_delivery_items(order_local_delivery_items_id) {
            if (confirm('هل انت متاكد من عملية الحذف ؟')) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '{{ route('procurement_officer.orders.delivery.delete_order_local_delivery_items') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'order_local_delivery_items_id': order_local_delivery_items_id,
                    },
                    success: function (data) {
                        if (data.success == 'true') {
                            $('#order_item_delivery_row_' + order_local_delivery_items_id).remove();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            }
        }

        function edit_order_local_delivery_items(order_local_delivery_items_id) {
            if (confirm('هل انت متاكد من عملية الحذف ؟')) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '{{ route('procurement_officer.orders.delivery.delete_order_local_delivery_items') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'order_local_delivery_items_id': order_local_delivery_items_id,
                    },
                    success: function (data) {
                        if (data.success == 'true') {
                            $('#order_item_delivery_row_' + order_local_delivery_items_id).remove();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            }
        }

        function update_order_local_delivery_items(order_local_delivery_items_id,estimation_price) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('procurement_officer.orders.delivery.update_order_local_delivery_items') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_local_delivery_items_id': order_local_delivery_items_id,
                    'estimation_price':estimation_price
                },
                success: function (data) {
                    if (data.success == 'true') {
                        toastr.success('تم تعديل التكلفة بنجاح');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });

        }

    </script>

    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false, 'search': false
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

        $(function () {
            $("#example11").DataTable({
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

