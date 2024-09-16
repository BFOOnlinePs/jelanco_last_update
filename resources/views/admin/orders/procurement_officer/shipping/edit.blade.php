@extends('home')
@section('title')
    تعديل توصيل دولي (شحن)
@endsection
@section('header_title')
    تعديل توصيل دولي (شحن)
@endsection
@section('header_link')
    توصيل دولي (شحن)
@endsection
@section('header_title_link')
    تعديل توصيل دولي (شحن)
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
            <form action="{{ route('procurement_officer.orders.shipping.update') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $data->id }}" name="id">
                <div class="row">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">شركة الشحن</label>
                            <select class="form-control select2bs4" name="shipping_company_id" id="">
                                @foreach($user as $key)
                                    <option @if($key->shipping_company_id == $data->shipping_company_id) selected
                                            @endif value="{{ $key->id }}">{{ $key->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">السعر</label>
                            <input value="{{ $data->price }}" type="text" placeholder="يرجى كتابة السعر" name="price"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">العملة</label>
                            <select class="form-control select2bs4" name="currency_id"
                                    placeholder="يرجى اختيار العملية" id="">
                                @foreach($currency as $key)
                                    <option @if($key->currency_id == $data->currency_id) selected
                                            @endif value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="@if(empty($data->attachment)) col-md-4 @else col-md-2 @endif">
                        <div class="form-group">
                            <label for="">المرفقات</label>
                            @if(!empty($data->attachment))
                                <a href="{{ asset('storage/attachment/',$data->attachment) }}"
                                   download="attachment"></a>
                            @endif
                            <input type="file" name="attachment" class="form-control">
                        </div>
                    </div>
                    @if(!empty($data->attachment))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for=""></label>
                                <div>
                                    <a type="text"
                                       href="{{ asset('storage/attachment/'.$data->attachment) }}"
                                       download="{{ $data->attachment }}" class="btn btn-primary btn-sm"><span class="fa fa-download"></span></a>
                                    <button type="button" onclick="viewAttachment({{ $data->id }},'{{ asset('storage/attachment/'.$data->attachment) }}',null)" class="btn btn-success btn-sm" data-toggle="modal"
                                            data-target="#modal-lg-view_attachment"><span
                                            class="fa fa-search"></span></button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">نوع الشحن</label>
                            <select class="form-control" name="shipping_type" id="">
                                <option @if($data->shipping_type == 1) selected @endif value="1">بري</option>
                                <option @if($data->shipping_type == 2) selected @endif value="2">جوي</option>
                                <option @if($data->shipping_type == 3) selected @endif value="3">بحري</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">تصنيف الشحن</label>
                            <select onchange="selectShippingRating()" class="form-control" name="shipping_rating"
                                    id="shipping_rating">
                                <option @if($data->shipping_rating == 1) selected @endif value="1">جزئي</option>
                                <option @if($data->shipping_rating == 2) selected @endif value="2">حاوية</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" id="partial_charge">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">CBM</label>
                            <input value="{{ $data->cbn }}" name="cbn" type="text" class="form-control"
                                   placeholder="CBM">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">الوزن الاجمالي</label>
                            <input value="{{ $data->total_weight }}" name="total_weight" type="text"
                                   class="form-control" placeholder="الوزن الاجمالي">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">الوزن الصافي</label>
                            <input value="{{ $data->net_weight }}" name="net_weight" type="text" class="form-control"
                                   placeholder="الوزن الصافي">
                        </div>
                    </div>
                </div>
                <div class="row" id="container_charge">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">حجم الحاوية</label>
                            <select class="form-control" name="container_size" id="">
                                <option @if($data->container_size == 20) selected @endif value="20">20 قدم</option>
                                <option @if($data->container_size == 40) selected @endif value="40">40 قدم</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">التبريد</label>
                            <select class="form-control" name="cooling_type" id="">
                                <option @if($data->cooling_type == 1) selected @endif value="1">نعم</option>
                                <option @if($data->cooling_type == 0) selected @endif value="0">لا</option>
                            </select></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">طرق الشحن</label>
                            <select class="form-control" name="shipping_method" id="">
                                @foreach($shipping_methods as $key)
                                    <option @if($data->shipping_method == $key->id) selected @endif value="{{ $key->id }}">
                                        {{ $key->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <labe>الملاحظات</labe>
                            <textarea name="note" class="form-control" placeholder="يرجى كتابة الملاحظات" id=""
                                      cols="30" rows="3">{{ $data->note }}</textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">تعديل</button>
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
        window.onload = function () {
            var shipping_rating = document.getElementById('shipping_rating');
            if (shipping_rating.value == 1) {
                $('#partial_charge').show();
                $('#container_charge').hide();
            } else if (shipping_rating.value == 2) {
                $('#container_charge').show();
                $('#partial_charge').hide();
            }
        };
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

