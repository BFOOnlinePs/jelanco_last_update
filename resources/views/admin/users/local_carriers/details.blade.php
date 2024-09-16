@extends('home')
@section('title')
    شركات النقل المحلي
@endsection
@section('header_title')
    شركات النقل المحلي
@endsection
@section('header_link')
    المستخدمين
@endsection
@section('header_title_link')
    شركات النقل المحلي
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/main.css') }}">

@endsection
@section('content')

    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">
        {{--        <div class="card-header text-center">--}}
        {{--            <h5 class="text-bold">تفاصيل المورد</h5>--}}
        {{--        </div>--}}
        <div class="card-body">
            <style>
                .active {
                    color: black !important;
                }

                .nav-link {
                    text-decoration: none;
                }
            </style>


            {{--            <form action="{{ route('users.supplier.create') }}" method="post" enctype="multipart/form-data">--}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <h3 class="pb-3">{{ $data->name }}</h3>
                        <ul class="nav nav-tabs alert-info text-white" style="" id="custom-content-below-tab"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-white" id="custom-content-below-home-tab"
                                   data-toggle="pill"
                                   href="#custom-content-below-home" role="tab"
                                   aria-controls="custom-content-below-home" aria-selected="true">المعلومات العامة</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" id="custom-content-below-profile-tab" data-toggle="pill"
                                   href="#custom-content-below-profile" role="tab"
                                   aria-controls="custom-content-below-profile" aria-selected="false">معلومات البنك</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" id="custom-content-below-messages-tab" data-toggle="pill"
                                   href="#custom-content-below-messages" role="tab"
                                   aria-controls="custom-content-below-messages" aria-selected="false">جهات الاتصال</a>
                            </li>
                            {{--                                                        <li class="nav-item">--}}
                            {{--                                                            <a class="nav-link text-white" id="custom-content-below-settings-tab" data-toggle="pill"--}}
                            {{--                                                               href="#custom-content-below-settings" role="tab"--}}
                            {{--                                                               aria-controls="custom-content-below-settings" aria-selected="false">الطلبيات</a>--}}
                            {{--                                                        </li>--}}
                            <li class="nav-item">
                                <a class="nav-link text-white @if(session('tab_id') == 4) active @endif" id="custom-content-below-cost_estimate-tab"
                                   data-toggle="pill"
                                   href="#custom-content-below-cost_estimate" role="tab"
                                   aria-controls="custom-content-below-cost_estimate" aria-selected="false">تقدير
                                    التكلفة</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="custom-content-below-tabContent">
                            <div class="tab-pane fade @if(empty('tab_id')) active show @endif" id="custom-content-below-home" role="tabpanel"
                                 aria-labelledby="custom-content-below-home-tab">
                                <div class="p-2">
                                    <div class="row">
                                        <div class="col-md-8 p-5">
                                            <div class="form-group">
                                                <label for="">الاسم :</label>
                                                <span class="form-control">{{ $data->name }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="">الايميل :</label>
                                                <span class="form-control">{{ $data->email }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="">رقم الهاتف الاول :</label>
                                                <span class="form-control">{{ $data->user_phone1 }}</span>
                                            </div>
                                            <div class="form-group">
                                                @if($data->user_phone2 == '')
                                                    <label for="">رقم الهاتف الثاني :</label>
                                                    <span class="form-control">لا يوجد</span>
                                                @else
                                                    <label for="">رقم الهاتف الثاني :</label>
                                                    <span class="form-control">{{ $data->user_phone2 }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="">حالة المستخدم</label>
                                                @if($data->status == 1)
                                                    <span class="form-control text-success">فعال</span>
                                                @elseif($data->status == 0)
                                                    <span class="text-danger form-control">غير فعال</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="">ملاحظات : </label>
                                                <textarea readonly class="form-control" name="" id="" cols="30"
                                                          rows="3">{{ $data->user_notes }}</textarea>
                                            </div>
                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label for="">الموقع الالكتروني : <span><a--}}
                                            {{--                                                            href="">{{ $data->user_website }}</a></span></label>--}}
                                            {{--                                            </div>--}}
                                            <div class="form-group">
                                                <label for="">العنوان :</label>
                                                <textarea readonly class="form-control" name="" id="" cols="30"
                                                          rows="3">{{ $data->user_address }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">مجال العمل :</label>
                                                <span class="form-control"></span>
                                            </div>


                                        </div>
                                        <div class="col-md-4 pt-5 text-center">
                                            <div class="form-group text-center">
                                                <img width="150"
                                                     src="{{ asset('storage/user_photo/'.$data->user_photo) }}"
                                                     alt="">
                                            </div>
                                            <div>
                                                <h4 class="text-center">{{ $data->name }}</h4>
                                                <hr>
                                                <p>يحتوي هذا القسم على المعلومات الاساسية لأمين المستودع</p>
                                                <a href="{{ route('users.storekeeper.edit',['id'=>$data->id]) }}"
                                                   class="btn btn-info">تعديل بيانات شركة النقل المحلي</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel"
                                 aria-labelledby="custom-content-below-profile-tab">
                                <div class="row">
                                    <div class="col-md-8 p-5">
                                        <div class="form-group">
                                            <label for="">اسم المستفيد :</label>
                                            <input class="form-control" type="text" name="account_owner"
                                                   placeholder="اسم جهة الحساب">
                                        </div>
                                        <div class="form-group">
                                            <label>رقم حساب البنك :</label>
                                            <span
                                                class="form-control">{{ $data->user_account_number }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label>اسم البنك :</label>
                                            <span
                                                class="form-control">{{ $data->user_bank_name }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label>عنوان البنك :</label>
                                            <textarea disabled class="form-control" name="" id=""
                                                      cols="30"
                                                      rows="3">{{ $data->user_bank_address }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Swift code :</label>
                                            <span
                                                class="form-control">{{ $data->user_swift_code }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label>IBAN Number :</label>
                                            <span
                                                class="form-control">{{ $data->user_iban_number }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center pt-5">
                                            <i class="fa-solid fa-building-columns text-info"
                                               style="font-size: 180px"></i>
                                            <br><br>
                                            <h4>معلومات البنك</h4>
                                            <hr>
                                            <p>يحتوي هذا القسم على جميع معلومات البنك الذي يتم التعامل معه بواسطة هذا
                                                المورد</p>
                                            <a href="" class="btn btn-info">تعديل بيانات البنك</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-messages" role="tabpanel"
                                 aria-labelledby="custom-content-below-messages-tab">
                                <div class="row">
                                    <div class="col-md-8 pt-5">
                                        <label for="">جهة التواصل</label>
                                        <table style="font-size: 14px;border: solid 1px black;width: 100%"
                                               id="contact_person_table"
                                               class="table-hover table-bordered text-center">
                                            <thead>
                                            <tr>
                                                <th>الصورة</th>
                                                <th>الاسم</th>
                                                <th>الهاتف</th>
                                                <th>الايميل</th>
                                                <th>الوتس اب</th>
                                                <th>الوي شات</th>
                                                <th>العنوان</th>
                                                <th>العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($company_contact_person as $key)
                                                <tr id="delete_{{$key->id}}">
                                                    <td><img style="width: 30px;height: 30px" class="p-1"
                                                             src="{{ asset('storage/user_photo/avatar.png') }}" alt="">
                                                    </td>
                                                    <td>{{ $key->contact_name }}</td>
                                                    <td>{{ $key->mobile_number }}</td>
                                                    <td>{{ $key->email }}</td>
                                                    <td>{{ $key->whats_app_number }}</td>
                                                    <td>{{ $key->wechat_number }}</td>
                                                    <td>{{ $key->address }}</td>
                                                    <td>
                                                        <button onclick="deleteMessage({{ $key->id }})"
                                                                class="btn btn-sm btn-danger">X
                                                        </button>
                                                    </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center pt-5">
                                            <i class="fa-solid fa-address-card text-info" style="font-size: 180px"></i>
                                            <br><br>
                                            <h4>معلومات جهات الاتصال</h4>
                                            <hr>
                                            <p>يحتوي هذا القسم على معلومات جهات الاتصال التي يتم التواصل من خلالها مع
                                                هذا المورد</p>
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                    data-target="#modal-default">
                                                اضافة جديد
                                            </button>
                                            <div class="modal fade" id="modal-default">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('company_contact_person.supplier.create') }}"
                                                          method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="text" hidden name="company_id"
                                                               value="{{ $data->id }}">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">اضافة جهة تواصل جديدة</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="">الاسم</label>
                                                                    <input name="contact_name" class="form-control"
                                                                           type="text"
                                                                           placeholder="الاسم">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">رقم الهاتف</label>
                                                                    <input name="mobile_number" class="form-control"
                                                                           type="text"
                                                                           placeholder="رقم الهاتف">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">البريد الالكتروني</label>
                                                                    <input name="email" class="form-control" type="text"
                                                                           placeholder="البريد الالكتروني">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">رقم WhatsApp</label>
                                                                    <input name="whats_app_number" class="form-control"
                                                                           type="text"
                                                                           placeholder="رقم الواتس اب">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">رقم WeChat</label>
                                                                    <input name="wechat_number" class="form-control"
                                                                           type="text"
                                                                           placeholder="رقم وي شات">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">العنوان</label>
                                                                    <textarea class="form-control" name="address" id=""
                                                                              cols="30"
                                                                              rows="2" placeholder="العنوان"></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">الصورة</label>
                                                                    <div class="custom-file">
                                                                        <input name="photo" type="file"
                                                                               class="custom-file-input"
                                                                               id="customFile">
                                                                        <label class="custom-file-label"
                                                                               for="customFile">تحميل
                                                                            صورة</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-danger"
                                                                        data-dismiss="modal">اغلاق
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">حفظ
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </form>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-settings" role="tabpanel"
                                 aria-labelledby="custom-content-below-settings-tab">
                                <div class="p-2">
                                    <h5 class="text-center">قريبا ..</h5>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(session('tab_id') == 4) active show @endif" id="custom-content-below-cost_estimate" role="tabpanel"
                                 aria-labelledby="custom-content-below-cost_estimate-tab">
                                <div class="row mt-2">
                                    <button type="button" class="btn btn-dark" data-toggle="modal"
                                            data-target="#modal-lg">
                                        اضافة تقدير للتكلفة <span class="fa fa-plus"></span>
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-hover table-sm mt-2">
                                            <thead>
                                                <tr>
                                                    <th>الاسم</th>
                                                    <th>التكلفة</th>
                                                    <th>العملة</th>
                                                    <th>العمليات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($delivery_estimation_cost as $key)
                                                <tr>
                                                    <td>{{ $key['element_cost']->name }}</td>
                                                    <td>{{ $key->estimation_price }}</td>
                                                    <td>{{ $key['currency']->currency_name }}</td>
                                                    <td>
                                                        <a href="{{ route('users.local_carriers.edit_delivery',['id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                                        <a href="{{ route('users.local_carriers.delete_delivery',['id'=>$key->id]) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('users.local_carriers.create_delivery_estimation_cost') }}" method="post">
                    @csrf
                    <input type="hidden" name="company_id" value="{{ $data->id }}">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة تقدير للتكلفة</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">اختر التقدير</label>
                                    <select class="form-control select2bs4" required name="element_cost_id" id="">
                                        <option value="" selected>اختر التقدير ..</option>
                                        @foreach($estimation_cost_element as $key)
                                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">التكلفة</label>
                                    <input name="estimation_price" required class="form-control" type="text" placeholder="التكلفة">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">العملة</label>
                                    <select required class="form-control" name="currency_id" id="">
                                        <option value="" selected>اختر عملة ..</option>
                                        @foreach($currency as $key)
                                            <option value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">خروج</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>

            </div>

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

    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/fullcalendar/main.js') }}"></script>

    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>

    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>


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

    <script>
        function add_contact_person() {
            var contact_person_table = document.getElementById('contact_person_table');
            var count = {{ \App\Models\CompanyContactPersonModel::count() }};
            if (contact_person_table.rows.length == count + 1) {
                var new_row = contact_person_table.insertRow();
                var cell1 = new_row.insertCell();
                var cell2 = new_row.insertCell();
                var cell3 = new_row.insertCell();
                var cell4 = new_row.insertCell();
                cell1.innerText = '2';
                cell2.innerText = 'test2';
                cell3.innerHTML = '<button class="btn btn-sm btn-dark">تفاصيل</button>';
                cell4.innerHTML = '<button class="btn btn-sm btn-danger">X</button>';
            } else {
                alert('يرجى تعبئة الحقل الفارغ')
            }
            console.log(contact_person_table.rows.length);
            // console.log(count);

        }

        function deleteMessage(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            var confirmationMessage = "هل انت متاكد انك تريد حذف البيانات ؟";
            var userConfirmed = window.confirm(confirmationMessage);
            if (userConfirmed) {
                $.ajax({
                    url: '{{ url('company_contact_person/delete') }}' + '/' + id,
                    method: 'get',
                    headers: headers,
                    success: function (data) {
                        document.getElementById('delete_' + id).remove();
                        toastr.success('تم حذف البيانات بنجاح')
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
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'addEventButton',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                defaultDate: '2018-11-16',
                navLinks: true,
                editable: true,
                eventLimit: true,
                selectable: true,
                events: [{
                    title: 'Simple static event',
                    start: '2018-11-16',
                    description: 'Super cool event'
                },

                ],
                select: function (startDate, endDate) {
                    var dateStart = moment(startDate);
                    var dateEnd = moment(endDate);

                    if (dateStart.isValid() && dateEnd.isValid()) {
                        $('#calendar-5').fullCalendar('renderEvent', {
                            title: 'Long event',
                            start: dateStart,
                            end: dateEnd,
                            allDay: true
                        });
                    }
                }
            });
        });

    </script>

@endsection

