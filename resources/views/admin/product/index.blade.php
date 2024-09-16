@extends('home')
@section('title')
    الاصناف
@endsection
@section('header_title')
    الاصناف
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    الاصناف
@endsection
@section('style')
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
            margin: 0 0 20px -180px;
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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('product.import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">استيراد من اكسيل</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">ارفاق الملف</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input"
                                           id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">اختر ملف</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">ارفاق الملف</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-dark">حفظ</button>
                    </div>
                </form>

            </div>
        </div>
    </div>



    <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة صنف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('product.create') }}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">اسم الصنف عربي</label>
                                <input name="product_name_ar" type="text" class="form-control" placeholder="اسم الصنف عربي">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">اسم الصنف انجليزي</label>
                                <input name="product_name_en" type="text" class="form-control" placeholder="اسم الصنف انجليزي">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" data-select2-id="41">
                                <label>تصنيف المنتج</label>
                                <select name="category_id" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;"
                                        data-select2-id="1" tabindex="-1" aria-hidden="true">
                                    @foreach($category as $key)
                                        <option value="{{ $key->id }}">{{ $key->cat_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" data-select2-id="41">
                                <label>الوحدة</label>
                                <select name="unit_id" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;"
                                        data-select2-id="2" tabindex="-1" aria-hidden="true">
                                    @foreach($unit as $key)
                                        <option value="{{ $key->id }}">{{ $key->unit_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">باركود المنتج</label>
                                <input name="barcode" class="form-control" type="text" placeholder="باركود المنتج">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" data-select2-id="41">
                                <label>اقل كمية</label>
                                <input type="text" name="less_qty" placeholder="اقل كمية" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">صورة المنتج</label>
                                <div class="custom-file">
                                    <input name="product_photo" type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">اختر ملف</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">معتمد / غير معتمد</label><br>
                                <select name="certified" class="form-control w-25 ml-2" style="float: right" id="">
                                    <option value="1">معتمد</option>
                                    <option value="0">غير معتمد</option>
                                </select>
                                <b class="">(معتمد بحاجة الى عرض سعر واحد فقط اما الغير معتمد بحاجة الى 3 عروض اسعار)</b>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">سعر المنتج</label>
                                <input name="product_price" height="50" class="form-control" type="text" placeholder="سعر المتنج">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark">حفظ</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @include('admin.product.home_menu')
    <div class="mb-2">
        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modal-xl">
            <span class="fa fa-plus"></span> اضافة صنف
        </button>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
            <span class="fa fa-file-import"></span> استيراد من اكسيل
        </button>

    </div>

    <div class="card">

        <div class="card-header">
            <h3 class="text-center">قائمة الأصناف</h3>
        </div>

        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <input onkeyup="fetchAdditionalData()" id="input_search" name="product_search" type="text" placeholder="بحث" class="form-control mb-2">
                    <div id="search_table" style="width: 100%">

                    </div>
                </div>
            </div>
        </div>
        <div class="loader-container" id="loaderContainer" style="display: none;">
            <div class="loader"></div>
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

    {{--        <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>--}}

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>


    <script>
        $(document).ready(function() {
            showLoader();
            fetchAdditionalData();
        });

        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetchAdditionalData(page);
        });
        function fetchAdditionalData(page = 1) {
            // showLoader();
            $.ajax({
                url: '{{ url('/product/search_table') }}',
                type: 'get',
                data:{
                    'product_search':document.getElementById('input_search').value,
                    'page': page
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                beforeSend: function() {
                    // showLoader();
                },
                success: function(data) {
                    console.log(data);
                    // alert(data);
                    $('#search_table').html(data);
                },
                error: function(error) {
                    alert('error')
                },
                complete: function() {
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

        function myFunction(){
            alert('load');
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
        function edit_product_ajax(id) {
            if((document.getElementById('product_name_ar_' + id).value == '') && (document.getElementById('product_name_en_' + id).value)){
                alert('يجب ان لا يكون حقل الحروف فارغ');
            }
            else{
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '{{ route('product.edit_product_ajax') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'product_id': id,
                        'product_name_ar': document.getElementById('product_name_ar_' + id).value,
                        'product_name_en': document.getElementById('product_name_en_' + id).value,
                    },
                    success: function (data) {
                        // alert('mohamad');
                        console.log(data);
                        toastr.success('تم تعديل الاسم بنجاح')
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            }
        }
    </script>

    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": true, "autoWidth": true,
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
            $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

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
                    ranges   : {
                        'Today'       : [moment(), moment()],
                        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate  : moment()
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

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function(){
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

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
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

