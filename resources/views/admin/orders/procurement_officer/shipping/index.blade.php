@extends('home')
@section('title')
    توصيل دولي (شحن)
@endsection
@section('header_title')
    <span>توصيل دولي ( شحن ) <span>@if($order->reference_number != 0) #{{ $order->reference_number }} @endif</span></span>
@endsection
@section('header_link')
    طلبات الشراء
@endsection
@section('header_title_link')
    توصيل دولي (شحن)
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
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    {{--    <button type="button" class="btn btn-primary mb-2" data-toggle="modals" data-target="#modals-default">اضافة طلبية شراء--}}
    {{--    </button>--}}
    @include('admin.orders.order_menu')

    <div class="card">
        <div class="card-header">
            <h3 class="text-center">توصيل دولي (شحن)</h3>
        </div>

        <div class="card-body">
            <button type="button" class="btn btn-dark mb-2" data-toggle="modal" data-target="#modal-lg-shipping">اضافة
                عرض سعر
            </button>
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>شركة الشحن</th>
                        <th>نوع الشحن</th>
                        <th>تم اضافته بواسطة</th>
                        <th>السعر</th>
{{--                        <th>الحالة</th>--}}
                        <th>العملة</th>
                        <th>مرفقات</th>
                        <th>الملاحظات</th>
                        <th>العمليات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($data->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center"><span>لا يوجد بيانات</span></td>
                        </tr>
                    @else
                        @foreach($data as $key)
                            <tr>
                                <td>{{ $key['shipping']->name }}</td>
                                <td>
                                    @if($key->shipping_type == 1)
                                        <span>بري</span>
                                    @elseif($key->shipping_type == 2)
                                        <span>جوي</span>
                                    @elseif($key->shipping_type == 3)
                                        <span>بحري</span>
                                    @endif
                                </td>
                                <td>{{ $key['added_by']->name }}</td>
                                <td>{{ $key->price }}</td>
                                {{--                            <td>{{ $key->status }}</td>--}}
                                <td>{{ $key['currency']->currency_name }}</td>
                                <td>
                                    @if(empty($key->attachment))
                                        لا يوجد ملف
                                    @else
                                        <a class="btn btn-primary btn-sm" download="{{ $key->attachment }}"
                                           href="{{ asset('storage/attachment/'.$key->attachment) }}"><span class="fa fa-download"></span></a>
                                        <button onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->attachment) }}',null)" href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view_attachment"><span
                                                class="fa fa-search"></span></button>

                                    @endif
                                </td>
                                <td>{{ $key->note }}</td>
                                <td>
                                    <a class="btn btn-success btn-sm"
                                       href="{{ route('procurement_officer.orders.shipping.edit',['id'=>$key->id]) }}"><span class="fa fa-search"></span></a>
{{--                                    <a class="btn btn-dark btn-sm"--}}
{{--                                       href="{{ route('procurement_officer.orders.shipping.details',['id'=>$key->id]) }}">تفاصيل</a>--}}
                                    @if($key->award_status == 0)
                                        <button type="button" onclick="getId({{ $key->id }})" class="btn btn-warning btn-sm"
                                                data-toggle="modal" data-target="#modal-lg-award_shipping">
                                            ترسية
                                        </button>
                                    @else
                                        <a href="{{ route('procurement_officer.orders.shipping.shipping_award_status_disable',['id'=>$key->id]) }}"
                                           onclick="return confirm('هل تريد الغاء الترسية ؟')"
                                           class="btn btn-danger btn-sm">الغاء الترسية</a>
                                    @endif
                                    <a class="btn btn-danger btn-sm"
                                       onclick="return confirm('هل تريد الحذف لا يمكن ارجاع الباينات')"
                                       href="{{ route('procurement_officer.orders.shipping.delete',['id'=>$key->id]) }}">حذف</a>
                                </td>
                            </tr>
                        @endforeach

                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="modal-lg-shipping">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('procurement_officer.orders.shipping.create') }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $order->id }}" name="order_id">
                        <div class="modal-header">
                            <h4 class="modal-title">اضافة ملاحظة</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @csrf
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">شركة الشحن</label>
                                        <select required class="form-control select2bs4" name="shipping_company_id" id="">
                                            <option selected value="">اختر شركة الشحن ..</option>
                                            @foreach($user as $key)
                                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">السعر</label>
                                        <input required type="text" placeholder="يرجى كتابة السعر" name="price"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">العملة</label>
                                        <select required class="form-control select2bs4" name="currency_id"
                                                placeholder="يرجى اختيار العملية" id="">
                                            @foreach($currency as $key)
                                                <option value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">المرفقات</label>
                                        <input type="file" name="attachment" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">نوع الشحن</label>
                                        <select class="form-control" name="shipping_type" id="">
                                            <option value="1">بري</option>
                                            <option value="2">جوي</option>
                                            <option value="3">بحري</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">تصنيف الشحن</label>
                                        <select onchange="selectShippingRating()" class="form-control"
                                                name="shipping_rating" id="shipping_rating">
                                            <option value="1">جزئي</option>
                                            <option value="2">حاوية</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="partial_charge">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">CBM</label>
                                        <input name="cbn" type="text" class="form-control" placeholder="CBM">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">الوزن الاجمالي</label>
                                        <input name="total_weight" type="text" class="form-control"
                                               placeholder="الوزن الاجمالي">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">الوزن الصافي</label>
                                        <input name="net_weight" type="text" class="form-control"
                                               placeholder="الوزن الصافي">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="container_charge">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">حجم الحاوية</label>
                                        <select class="form-control" name="container_size" id="">
                                            <option value="20">20 قدم</option>
                                            <option value="40">40 قدم</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">التبريد</label>
                                        <select class="form-control" name="cooling_type" id="">
                                            <option value="1">نعم</option>
                                            <option value="0">لا</option>
                                        </select></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">طرق الشحن</label>
                                        <select required class="form-control" name="shipping_method" id="">
                                            <option selected value="">اختر طريقة الشحن ..</option>
                                            @foreach($shipping_methods as $key)
                                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                                            @endforeach
{{--                                            <option value="1">من المصنع ( EXW )</option>--}}
{{--                                            <option value="2">من ميناء المورد ( FOB )</option>--}}
{{--                                            <option value="3">من ميناء المشتري مع تأمين ( CIF )</option>--}}
{{--                                            <option value="4">من ميناء المشتري بدون تأمين ( C&F )</option>--}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <labe>الملاحظات</labe>
                                        <textarea name="note" class="form-control" placeholder="يرجى كتابة الملاحظات"
                                                  id=""
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
        <div class="modal fade" id="modal-lg-award_shipping">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('procurement_officer.orders.shipping.create_shipping_award') }}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $order->id }}" name="order_id">
                        <input type="hidden" id="id" name="id">
                        <div class="modal-header">
                            <h4 class="modal-title">ترسية</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">تاريخ حجز الشحن</label>
                                        <input required name="shipping_reservation_date" type="text"
                                               class="form-control date_format">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">تاريخ الخروج المتوقع</label>
                                        <input name="expected_exit_date" required type="text" class="form-control date_format">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">تاريخ الوصول المتوقع</label>
                                        <input name="expected_arrival_date" required type="text" class="form-control date_format">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">خط الشحن</label>
                                        <input name="shipping_line" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">بوليصة شحن اولية</label>
                                        <input name="Initial_bill_of_lading" type="file" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">بوليصة شحن فعلية</label>
                                        <input name="actual_bill_of_lading" type="file" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">ملاحظات</label>
                                        <textarea class="form-control" name="award_notes" id="" cols="30"
                                                  rows="3"></textarea>
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
    </div>
    @if(!($shipping_award->isEmpty()))
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">المرسى عليه</h5>
            </div>
            <div class="card-body">
                @foreach($shipping_award as $key)
                    <div class="callout callout-warning">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>{{ $key['comapny']->name }}</h5>
                            </div>
                            <div class="col-md-4" style="font-size: 12px">
                                <label for="">حالة الشحن</label><br>
                                <select class="@if($key->status == 0) bg-danger @elseif($key->status == 1) bg-info @elseif($key->status == 2) bg-warning @elseif($key->status == 3) bg-success @endif p-2" onchange="update_shipping_status({{ $key->id }},this.value)" name="" id="select_status">
                                    <option @if($key->status == 0) selected @endif value="0">لا توجد حالة للطلبية</option>
                                    <option @if($key->status == 1) selected @endif value="1">تحميل من ميناء المورد</option>
                                    <option @if($key->status == 2) selected @endif value="2">الإبحار في الطريق</option>
                                    <option @if($key->status == 3) selected @endif value="3">الوصول</option>
                                </select>
{{--                                @if(($key->status == 0))--}}
{{--                                    <span class="alert alert-danger">لا توجد حالة للطلبية</span>--}}
{{--                                @elseif($key->status == 1)--}}
{{--                                    <span class="alert alert-info">تحميل من ميناء المورد</span>--}}
{{--                                @elseif($key->status == 2)--}}
{{--                                    <span class="alert alert-info">الإبحار في الطريق</span>--}}
{{--                                @elseif($key->status == 3)--}}
{{--                                    <span class="alert alert-info">الوصول</span>--}}
{{--                                @endif--}}
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('procurement_officer.orders.shipping.edit_shipping_award',['id'=>$key->id]) }}"
                                   class="btn btn-warning" style="text-decoration: none">تعديل</a>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">تاريخ حجز الشحن</label>
                                    <span class="form-control">{{ $key->shipping_reservation_date }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">تاريخ الخروج المتوقع</label>
                                    <span class="form-control">{{ $key->expected_exit_date }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">تاريخ الدخول المتوقع</label>
                                    <span class="form-control">{{ $key->expected_arrival_date }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">خط الشحن</label>
                                    <span class="form-control">{{ $key->shipping_line }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">بوليصة شحن اولية</label>
                                    <br>
                                    @if(!empty($key->Initial_bill_of_lading))
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ asset('storage/attachment/'.$key->Initial_bill_of_lading) }}"
                                           download="{{ $key->Initial_bill_of_lading }}"><span class="fa fa-download"></span></a>
                                        <button onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->Initial_bill_of_lading) }}',null)" href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view_attachment"><span
                                                class="fa fa-search"></span></button>

                                    @else
                                        لا يوجد ملف
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">بوليصة شحن فعلية</label>
                                    <br>
                                    @if(!empty($key->actual_bill_of_lading))
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ asset('storage/attachment/'.$key->actual_bill_of_lading) }}"
                                           download="{{ $key->actual_bill_of_lading }}"><span class="fa fa-download"></span></a>
                                        <button onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->actual_bill_of_lading) }}',null)" href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view_attachment"><span
                                                class="fa fa-search"></span></button>
                                    @else
                                        لا يوجد ملف
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if(!empty($key->award_notes))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">ملاحظات الترسية</label>
                                        <textarea readonly class="form-control" name="award_notes" id="" cols="30"
                                                  rows="3">{{ $key->award_notes }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
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
        function getId(id) {
            document.getElementById('id').value = id;
        }
    </script>

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

        function update_shipping_status(id,status) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': csrfToken}});

            $.ajax({
                url: '{{ route('procurement_officer.orders.shipping.update_shipping_status') }}',
                method: 'post',
                data: {
                    'id' : id,
                    'status' : status
                },
                success: function (data) {
                    if(data.success === 'true'){
                        if(status == 0){
                            $('#select_status').removeClass('bg-danger bg-success bg-info bg-warning').addClass('bg-danger');
                        }
                        else if(status == 1){
                            $('#select_status').removeClass('bg-danger bg-success bg-info bg-warning').addClass('bg-info');
                        }
                        else if(status == 2){
                            $('#select_status').removeClass('bg-danger bg-success bg-info bg-warning').addClass('bg-warning');
                        }
                        else if(status == 3){
                            $('#select_status').removeClass('bg-danger bg-success bg-info bg-warning').addClass('bg-success');
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {

                },
            });
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

