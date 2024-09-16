@extends('home')
@section('title')
    الترسية الخاصة بالشحن
@endsection
@section('header_title')
    الترسية الخاصة بالشحن
@endsection
@section('header_link')
    الشحن
@endsection
@section('header_title_link')
    الترسية الخاصة بالشحن
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

    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    {{--    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-default">اضافة طلبية شراء--}}
    {{--    </button>--}}

    <div class="card">
        <div class="card-body">
            <form action="{{ route('procurement_officer.orders.shipping.update_shipping_award') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $data->id }}" name="id">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">تاريخ حجز الشحن</label>
                            <input required class="form-control date_format" name="shipping_reservation_date" type="text" value="{{ $data->shipping_reservation_date }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">تاريخ الخروج المتوقع</label>
                            <input class="form-control date_format" name="expected_exit_date" type="text" value="{{ $data->expected_exit_date }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">تاريخ الدخول المتوقع</label>
                            <input class="form-control date_format" name="expected_arrival_date" type="text" value="{{ $data->expected_arrival_date }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">خط الشحن</label>
                            <input class="form-control" name="shipping_line" type="text" value="{{ $data->shipping_line }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">حالة الشحن</label>
                            <select required class="form-control" name="status" id="">
                                <option value="">اختر حالة الطلبية ..</option>
                                <option @if($data->status == 1) selected @endif value="1">تحميل من ميناء المورد</option>
                                <option @if($data->status == 2) selected @endif value="2">الإبحار في الطريق</option>
                                <option @if($data->status == 3) selected @endif value="3">الوصول</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">بوليصة شحن اولية</label>
                            @if(!empty($data->Initial_bill_of_lading))
                                <a type="text"
                                   href="{{ asset('storage/attachment/'.$data->Initial_bill_of_lading) }}"
                                   download="{{ $data->Initial_bill_of_lading }}" class="btn btn-primary btn-sm"><span class="fa fa-download"></span></a>
                                <button onclick="viewAttachment({{ $data->id }},'{{ asset('storage/attachment/'.$data->Initial_bill_of_lading) }}',null)" href="" class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#modal-lg-view_attachment"><span
                                        class="fa fa-search"></span></button>
{{--                                <button class="btn btn-primary btn-sm" download="attachment"--}}
{{--                                   href="{{ asset('storage/attachment/'.$data->Initial_bill_of_lading) }}"><span class="fa fa-download"></span></button>--}}
{{--                                <button onclick="viewAttachment('{{ asset('storage/attachment/'.$data->Initial_bill_of_lading) }}')" href="" class="btn btn-success btn-sm" data-toggle="modal"--}}
{{--                                        data-target="#modal-lg-view_attachment"><span--}}
{{--                                        class="fa fa-search"></span></button>                            @else--}}
{{--                                <span class="text-bold">( لا يوجد ملف )</span>--}}
                            @endif
                            <input type="file" name="Initial_bill_of_lading" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">بوليصة شحن فعلية</label>
                            @if(!empty($data->actual_bill_of_lading))
                                <a type="text"
                                   href="{{ asset('storage/attachment/'.$data->actual_bill_of_lading) }}"
                                   download="{{ $data->actual_bill_of_lading }}" class="btn btn-primary btn-sm"><span class="fa fa-download"></span></a>
                                <button type="button" onclick="viewAttachment('{{ asset('storage/attachment/'.$data->actual_bill_of_lading) }}')" class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#modal-lg-view_attachment"><span
                                        class="fa fa-search"></span></button>

                            @else
                                <span class="text-bold">( لا يوجد ملف )</span>
                            @endif
                            <input type="file" name="actual_bill_of_lading" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">ملاحظات الترسية</label>
                            <textarea class="form-control" name="award_notes" id="" cols="30" rows="3">{{ $data->award_notes }}</textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">حفظ التغييرات <span class="fa fa-edit"></span></button>

            </form>
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
        $('#container_charge').hide();
        $('#partial_charge').show();

        function selectShippingRating() {
            var shipping_rating = document.getElementById('shipping_rating');
            if (shipping_rating.value == 1) {
                $('#partial_charge').show();
                $('#container_charge').hide();
            } else if (shipping_rating.value == 2) {
                $('#container_charge').show();
                $('#partial_charge').hide();
            }
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
            showLoader();
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

