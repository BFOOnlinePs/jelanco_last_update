@extends('home')
@section('title')
    التقارير
@endsection
@section('header_title')
    التقارير
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    التقارير
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="modal fade" id="supplier-report-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تقرير مورد</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form target="_blank" action="{{ route('reports.suppliers.supplier_report') }}" method="post">
                    @csrf
                    <div class="info-box shadow-none">
                        <span class="info-box-icon"><i class="fa fa-bank"></i></span>
                        <div class="info-box-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">اختر مورد</label>
                                        <select required class="form-control select2bs4" name="supplier_id" id="">
                                            <option value="" selected>اختر مورد ..</option>
                                            @foreach($supplier as $key)
                                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">من تاريخ</label>
                                        <input dir="rtl" type="text" name="from" value="<?php echo date('Y-01-01'); ?>" class="form-control date_format">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">الى تاريخ</label>
                                        <input dir="rtl" type="text" name="to" value="<?php echo date('Y-m-d'); ?>" class="form-control date_format">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-dark btn-sm">عرض التقرير</button>
                            {{--                        <span class="info-box-number">None</span>--}}
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="details-supplier-report-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تقرير مورد مفصل</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form target="_blank" action="{{ route('reports.suppliers.details_supplier_report') }}" method="post">
                    @csrf
                    <div class="info-box shadow-none">
                        <span class="info-box-icon"><i class="fa fa-bank"></i></span>
                        <div class="info-box-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">اختر مورد</label>
                                        <select required class="form-control select2bs4" name="supplier_id" id="">
                                            <option value="" selected>اختر مورد ..</option>
                                            @foreach($supplier as $key)
                                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">من تاريخ</label>
                                        <input type="text" name="from" value="<?php echo date('Y-01-01'); ?>" class="form-control date_format">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">الى تاريخ</label>
                                        <input type="text" name="to" value="<?php echo date('Y-m-d'); ?>" class="form-control date_format">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">حالة الطلبية</label>
                                        <select class="form-control" name="order_status" id="">
                                            <option value="">جميع الحالات</option>
                                            @foreach($order_status as $key)
                                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-dark btn-sm">عرض التقرير</button>
                            {{--                        <span class="info-box-number">None</span>--}}
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="products-to-the-company-report-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">عرض الصنف حسب الشركة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form target="_blank" action="{{ route('reports.products.products_to_the_company_report') }}" method="post">
                    @csrf
                    <div class="info-box shadow-none">
                        <span class="info-box-icon"><i class="fa fa-bank"></i></span>
                        <div class="info-box-content">
                            <select class="form-control select2bs4" name="user_id" id="">
                                @foreach($supplier as $key)
                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                @endforeach
                            </select>
                            <br>
                            <button class="btn btn-dark btn-sm">عرض التقرير</button>
                            {{--                        <span class="info-box-number">None</span>--}}
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <a target="_blank" href="{{ route('reports.suppliers.suppliers_report') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="far fa-dollar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">قائمة الموردين</span>
                        {{--                        <span class="info-box-number">None</span>--}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            {{--            <a href="{{ route('bank.index') }}" style="text-decoration: none" class="text-dark">--}}
            <a data-toggle="modal" data-target="#supplier-report-lg" style="text-decoration: none"
                    class="text-dark">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">تقرير مورد</span>
                        {{--                        <span class="info-box-number">None</span>--}}
                    </div>
                </div>
            </a>
            {{--            </a>--}}
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            {{--            <a href="{{ route('bank.index') }}" style="text-decoration: none" class="text-dark">--}}
            <a data-toggle="modal" data-target="#details-supplier-report-lg" style="text-decoration: none"
                    class="text-dark">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="fa fa-user-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">تقرير مورد مفصل</span>
                    </div>
                </div>
            </a>
            {{--            </a>--}}
        </div>
{{--        <div class="col-md-3 col-sm-6 col-12">--}}
{{--            <a href="{{ route('reports.orders.order_index') }}" style="text-decoration: none" class="text-dark">--}}
{{--                <div class="info-box shadow-none">--}}
{{--                    <span class="info-box-icon"><i class="fa fa-tasks"></i></span>--}}
{{--                    <div class="info-box-content">--}}
{{--                        <span class="info-box-text text-center pt-3">عرض جميع الطلبات</span>--}}
{{--                        --}}{{--                        <span class="info-box-number">None</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </a>--}}
{{--        </div>--}}
        <div hidden class="col-md-3 col-sm-6 col-12">
            <a href="{{ route('reports.products.products_report') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="fa fa-list"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">الاصناف</span>
                        {{--                        <span class="info-box-number">None</span>--}}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            {{--            <a href="{{ route('estimation_cost_element.index') }}" style="text-decoration: none" class="text-dark">--}}
            <a data-toggle="modal" data-target="#products-to-the-company-report-lg" style="text-decoration: none">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="fa fa-building"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">تقرير أصناف الشركة</span>
                    </div>
                </div>
            </a>
            {{--            </a>--}}
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            {{--            <a href="{{ route('estimation_cost_element.index') }}" style="text-decoration: none" class="text-dark">--}}
            <a class="text-dark" href="{{ route('reports.financial_report.financial_report_index') }}" style="text-decoration: none">
                <div class="info-box shadow-none">
                    <span class="info-box-icon"><i class="fa fa-building"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-center pt-3">التقارير المالية</span>
                    </div>
                </div>
            </a>
            {{--            </a>--}}
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

    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>

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
