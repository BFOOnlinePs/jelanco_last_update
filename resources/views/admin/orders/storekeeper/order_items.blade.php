@extends('home')
@section('title')
    طلبات الشراء
@endsection
@section('header_title')
    طلب شراء <span>#{{ $order->id }}</span>
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
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card @if ($order->order_status == 0) bg-warning @else bg-success @endif">
        <div class="card-body">
            <form action="{{ route('orders.updateOrderStatus', ['order_id' => $order->id]) }}" method="post">
                @csrf
                <div class="div">
                    @if ($order->order_status == 0)
                        <spam>حالة الطلب (غير مرسل)</spam> <button class="btn btn-dark btn-sm"
                            onclick="return confirm('هل انت متاكد ؟')">اعتماد
                            وارسال</button>
                        <br>
                        <div class="form-group">
                            <label>وجهة الطلبية</label>
                            <div class="div" style="background-color: white">
                                <select class="select2bs4 form-control" name="to_user" id="">
                                    @foreach ($salesman as $key)
                                        <option value="{{ $key->id }}">{{ $key->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <hr>
                        <p class="text-bold">عند الانتهاء من اضافة الأصناف يرجى الضغط على زر الاعتماد ليتم ارسالها لقسم
                            المشتريات</p>
                    @else
                        <spam>حالة الطلب (تم ارسالها الى المشتريات)</spam>
                    @endif
                </div>
            </form>
        </div>
    </div>
    @if ($order->order_status == 0)
        <button type="button" class="btn btn-dark mb-2" data-toggle="modal" data-target="#modal-add-product">اضافة صنف
        </button>
    @endif
    @if ($order->order_status != 0)
        <a href="{{ route('users.storekeeper.shipping_details', ['order_id' => $order->id]) }}"
            class="mb-2 btn btn-info">تفاصيل الشحنة</a>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">طلب شراء</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="">ملاحظات</label>
                        <textarea onchange="update_notes_in_orders(this.value)" class="form-control" name="" id=""
                            cols="30" rows="2">{{ $order->st_notes }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('users.storekeeper.upload_attachment_in_order') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div style="float: left">
                            @if (!empty($order->st_attachment))
                                <a type="text" href="{{ asset('storage/attachment/' . $order->st_attachment) }}"
                                    download="{{ $order->st_attachment }}" class="btn btn-primary btn-sm"><span
                                        class="fa fa-download"></span></a>
                                <button type="button"
                                    onclick="viewAttachment({{ $order->id }},'{{ asset('storage/attachment/' . $order->st_attachment) }}',null)"
                                    href="" class="btn btn-success btn-sm" data-toggle="modal"
                                    data-target="#modal-lg-view_attachment"><span class="fa fa-search"></span></button>
                                <a onclick="confirm('هل انت متاكد من عملية الحذف ؟')"
                                    href="{{ route('users.storekeeper.delete_attachment_in_order', ['id' => $order->id]) }}"
                                    class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                            @endif
                            {{--                            <a href="{{ route('procurement_officer.orders.product.delete_attachment_in_product',['id'=>$order->id]) }}" class="btn btn-sm btn-danger"><span class="fa fa-trash"></span></a> --}}
                        </div>
                        <input type="hidden" name="id" value="{{ $order->id }}">
                        <div class="form-group">
                            <label for="exampleInputFile">المرفقات</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="attachment" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">رفع الملف</span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" style="display: none" id="submit_attachment"
                            class="btn btn-primary btn-sm">رفع المرفق</button>

                    </form>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div id="order_items_table">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('orders.create_order_items') }}" method="post">
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
                                type="text">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>الصنف</label>
                                    <select id="product" onchange="selectedUnit(this.value)" required name="product_id"
                                        class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;"
                                        data-select2-id="-1" tabindex="-1" aria-hidden="true">
                                        <option value="">اختر صنف</option>
                                        @foreach ($product as $key)
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
                                        class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;"
                                        data-select2-id="-2" tabindex="-1" aria-hidden="true">
                                        <option value="" selected>اختر وحدة</option>
                                        @foreach ($unit as $key)
                                            <option value="{{ $key->id }}">{{ $key->unit_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="">ملاحظات</label>
                            <textarea class="form-control" name="notes" id="" cols="30" placeholder="ادخل الملاحظات"
                                rows="3"></textarea>
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

    <div class="modal fade" id="modal-add-product">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('orders.procurement_officer.update_due_date') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="order_id_due_date" name="order_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة صنف</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" onkeyup="search_table_storekeeper_ajax()" id="search_product"
                            class="form-control" placeholder="البحث عن صنف">
                        <div class="row mt-2">
                            <div class="col-md-12" id="search_product_view">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
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

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>

    <script>
        $(document).ready(function() {
            search_table_storekeeper_ajax(page);
            order_items_table_ajax();
        });

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
                success: function(data) {
                    toastr.success('تم تعديل الكمية بنجاح')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function order_items_table_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('users.storekeeper.order_items_table_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': {{ $order->id }},
                },
                success: function(data) {
                    $('#order_items_table').html(data.view);
                },
                error: function(jqXHR, textStatus, errorThrown) {
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
                success: function(data) {
                    toastr.success('تم تعديل الوحدة بنجاح')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function create_order_items_ajax(product_id, unit_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('orders.create_order_items_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': {{ $order->id }},
                    'product_id': product_id,
                    'unit_id': unit_id
                },
                success: function(data) {
                    if (data.success == 'true') {
                        toastr.success(data.message);
                        search_table_storekeeper_ajax(page)
                        order_items_table_ajax();
                    } else if (data.success == 'true') {
                        toastr.error('تم تعديل الوحدة بنجاح')
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
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
                {{-- data: { --}}
                {{--    'order_id': {{ $order->id }}, --}}
                {{--    'order_items_id': order_items_id, --}}
                {{-- }, --}}
                success: function(data) {
                    document.getElementById('delete_tr_' + index).remove();
                    toastr.success('تم الحذف بنجاح')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        var products = {!! json_encode($product) !!};
        var units = {!! json_encode($unit) !!};

        function selectedUnit(product_id) {
            var selectedProduct = products.find(function(product) {
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
                units.forEach(function(unit) {
                    unitsSelect.append($('<option>', {
                        value: unit.id,
                        text: unit.unit_name,
                        selected: unit.id ==
                            selectedUnitId // Select the unit linked to the selected product
                    }));
                });

                // Refresh the select2 plugin (if you are using it)
                unitsSelect.trigger('change');
            }
        }

        function search_table_storekeeper_ajax(page = 1) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };

            $.ajax({
                url: '{{ route('users.storekeeper.search_table_storekeeper_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'search_product': document.getElementById('search_product').value,
                    'order_id': {{ $order->id }},
                    'page': page,
                },
                success: function(data) {
                    $('#search_product_view').html(data.view);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function search_product(search_product, page = 1) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };

            $.ajax({
                url: '{{ route('procurement_officer.orders.product.search_product_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'search_product': search_product,
                    'order_id': {{ $order->id }},
                    'page': page,
                },
                success: function(data) {
                    $('#search_product_view').html(data.view);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function update_notes_in_orders(value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };

            $.ajax({
                url: '{{ route('users.storekeeper.update_notes_in_orders') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': {{ $order->id }},
                    'st_notes': value,
                },
                success: function(data) {
                    toastr.success(data.message);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            if ($('#exampleInputFile').val() === '') {
                $('#submit_attachment').css('display', 'none');
            } else {
                $('#submit_attachment').css('display', 'block');
            }
        });

        $('#exampleInputFile').on('change', function() {
            if ($(this).val() === '') {
                $('#submit_attachment').css('display', 'none');
            } else {
                $('#submit_attachment').css('display', 'block');
            }
        })

        var page = 1;
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];

            // getOrderTable(page);
            search_table_storekeeper_ajax(page)
        });
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
