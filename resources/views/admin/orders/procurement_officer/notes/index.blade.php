@extends('home')
@section('title')
    ملاحظات
@endsection
@section('header_title')
    <span>ملاحظات <span>@if($order->reference_number != 0) #{{ $order->reference_number }} @endif</span></span>
@endsection
@section('header_link')
    طلبات الشراء
@endsection
@section('header_title_link')
    ملاحظات
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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
            <h3 class="text-center">الملاحظات</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <button type="button" class="btn btn-dark mb-2" data-toggle="modal"
                        data-target="#modal-lg-order_notes">اضافة ملاحظة
                </button>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>الفئة</th>
                            <th>الوصف</th>
                            <th>تاريخ الاضافة</th>
                            <th>تاريخ التنبيه</th>
                            <th>الملاحظة</th>
                            <th>العمليات</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!$price_offer->isEmpty())
                                @foreach($price_offer as $key)
                                    @if(!empty($key->notes))
                                        <tr>
                                            <td>عروض الاسعار</td>
                                            <td>
                                                دفعة بتاريخ - <span>{{ $key->created_at }}</span>
                                            </td>
                                            <td>{{ $key->insert_date }}</td>
                                            <td>{{ $key->alert_date }}</td>
                                            <td>
                                              {{ $key->notes }}
                                            </td>
                                            <td>
                                                <a target="_blank" href="{{ route('procurement_officer.orders.price_offer.edit_price_offer',['id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                                <a onclick="return confirm('هل انت متاكد من عملية الحذف ؟')" href="{{ route('procurement_officer.orders.notes.delete_note_from_order',['id'=>$key->id,'modal_name'=>'price_offer']) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                            @if(!$anchor->isEmpty())
                                @foreach($anchor as $key)
                                    @if(!empty($key->award_note))
                                        <tr>
                                            <td>ترسية</td>
                                            <td>
                                                ترسية عرض بتاريخ - <span>{{ $key->insert_at }}</span>
                                            </td>
                                            <td>{{ $key->created_at }}</td>
                                            <td>{{ $key->alert_date }}</td>
                                            <td>
                                                {{ $key->award_note }}
                                            </td>
                                            <td>
                                                <a href="{{ route('procurement_officer.orders.anchor.index',['order_id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                                <a onclick="return confirm('هل انت متاكد من عملية الحذف ؟')" href="{{ route('procurement_officer.orders.notes.delete_note_from_order',['id'=>$key->id,'modal_name'=>'anchor']) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                            @if(!$cash_payments->isEmpty())
                                @foreach($cash_payments as $key)
                                    @if(!empty($key->notes))
                                        <tr>
                                            <td>الدفعات</td>
                                            <td>
                                                دفعة بتاريخ - <span>{{ $key->insert_at }}</span>
                                            </td>
                                            <td>{{ $key->created_at }}</td>
                                            <td>{{ $key->alert_date }}</td>
                                            <td> {{ $key->notes }}</td>
                                            <td>
                                                <a href="{{ route('procurement_officer.orders.financial_file.edit_cash_payment',['id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                                <a onclick="return confirm('هل انت متاكد من عملية الحذف ؟')" href="{{ route('procurement_officer.orders.notes.delete_note_from_order',['id'=>$key->id,'modal_name'=>'cash_payment']) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                            @if(!$letter_bank->isEmpty())
                                @foreach($letter_bank as $key)
                                    @if(!empty($key->notes))
                                        <tr>
                                            <td>الاعتماد البنكي</td>
                                            <td>
                                                اعتماد بنكي في <span>{{ $key['bank']->user_bank_name }}</span>
                                            </td>
                                            <td>{{ $key->created_at }}</td>
                                            <td>{{ $key->alert_date }}</td>
                                            <td> {{ $key->notes }}</td>
                                            <td>
                                                <a href="{{ route('procurement_officer.orders.financial_file.edit_letter_bank',['id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                                <a onclick="return confirm('هل انت متاكد من عملية الحذف ؟')" href="{{ route('procurement_officer.orders.notes.delete_note_from_order',['id'=>$key->id,'modal_name'=>'letter_bank']) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                    @foreach($key['letter_bank_modification'] as $child)
                                        @if(!empty($key['letter_bank_modification']))
                                            @if(!empty($child->notes))
                                                <tr>
                                                    <td>تمديد الاعتماد البنكي</td>
                                                    <td>
                                                        تمديد اعتماد رقم - {{ $child->letter_bank_id }}
                                                    </td>
                                                    <td>{{ $key->created_at }}</td>
                                                    <td>{{ $key->alert_date }}</td>
                                                    <td> {{ $child->notes }}</td>
                                                    <td>
                                                        <a href="{{ route('procurement_officer.orders.financial_file.edit_extension',['id'=>$child->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                                        <a onclick="return confirm('هل انت متاكد من عملية الحذف ؟')" href="{{ route('procurement_officer.orders.notes.delete_note_from_order',['id'=>$key->id,'modal_name'=>'letter_bank_modification']) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            @endif
                            @if(!$shipping->isEmpty())
                                @foreach($shipping as $key)
                                    @if(!empty($key->note))
                                        <tr>
                                            <td>الشحن</td>
                                            <td>
                                                ملاحظات الشحن
                                            </td>
                                            <td>{{ $key->created_at }}</td>
                                            <td>{{ $key->alert_date }}</td>
                                            <td> {{ $key->note }}</td>
                                            <td>
                                                <a href="{{ route('procurement_officer.orders.shipping.edit',['id',$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                                <a onclick="return confirm('هل انت متاكد من عملية الحذف ؟')" href="{{ route('procurement_officer.orders.notes.delete_note_from_order',['id'=>$key->id,'modal_name'=>'shipping']) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                            @if(!$insurance->isEmpty())
                                @foreach($insurance as $key)
                                    @if(!empty($key->notes))
                                        <tr>
                                            <td>التأمين</td>
                                            <td>
                                                ملاحظات التامين
                                            </td>
                                            <td>{{ $key->created_at }}</td>
                                            <td>{{ $key->alert_date }}</td>
                                            <td> {{ $key->notes }}</td>
                                            <td>
                                                <a href="{{ route('procurement_officer.orders.insurance.edit',['id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                                <a onclick="return confirm('هل انت متاكد من عملية الحذف ؟')" href="{{ route('procurement_officer.orders.notes.delete_note_from_order',['id'=>$key->id,'modal_name'=>'insurance']) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                            @if(!$clerance->isEmpty())
                                @foreach($clerance as $key)
                                    @if(!empty($key->notes))
                                        <tr>
                                            <td>التخليص</td>
                                            <td>
                                                ملاحظات التخليص
                                            </td>
                                            <td>{{ $key->created_at }}</td>
                                            <td>{{ $key->alert_date }}</td>
                                            <td> {{ $key->notes }}</td>
                                            <td>
                                                <a href="{{ route('procurement_officer.orders.clearance.index',['order_id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                                <a onclick="return confirm('هل انت متاكد من عملية الحذف ؟')" href="{{ route('procurement_officer.orders.notes.delete_note_from_order',['id'=>$key->id,'modal_name'=>'clearance']) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                            @if(!$delivery->isEmpty())
                                @foreach($delivery as $key)
                                    @if(!empty($key->notes))
                                        <tr>
                                            <td>التوصيل</td>
                                            <td>
                                                ملاحظات التوصيل
                                            </td>
                                            <td>{{ $key->created_at }}</td>
                                            <td>{{ $key->alert_date }}</td>
                                            <td> {{ $key->notes }}</td>
                                            <td>
                                                <a href="{{ route('procurement_officer.orders.delivery.edit',['id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                                <a onclick="return confirm('هل انت متاكد من عملية الحذف ؟')" href="{{ route('procurement_officer.orders.notes.delete_note_from_order',['id'=>$key->id,'modal_name'=>'delivery']) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                            @if(!$order_notes->isEmpty())
                                @foreach($order_notes as $key)
                                    @if(!empty($key->note_text))
                                        <tr>
                                            <td>ملاحظات الطلبية</td>
                                            <td>
                                                {{ \App\Models\User::where('id',$key->user_id)->value('name') }}
                                            </td>
                                            <td>{{ $key->insert_date }}</td>
                                            <td>{{ $key->alert_date }}</td>
                                            <td> {{ $key->note_text }}</td>
                                            <td>
                                                <a href="{{ route('procurement_officer.orders.notes.edit_order_notes',['order_id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                                <a onclick="return confirm('هل انت متاكد من عملية الحذف ؟')" href="{{ route('procurement_officer.orders.notes.delete_note_from_order',['id'=>$key->id,'modal_name'=>'order_notes']) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal fade" id="modal-lg-order_notes">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('procurement_officer.orders.notes.create_order_notes') }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title">اضافة ملاحظة</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <div class="col-md-12">
                                        <label for="">نص الملاحظة</label>
                                        <textarea class="form-control" name="note_text" id="" cols="30" rows="4" placeholder="يرجى كتابة الملاحظة"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">تاريخ التنبيه</label>
                                        <input required name="alert_date" type="date" class="form-control text-center">
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

            <div class="modal fade" id="modal-lg-edit">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form id="modal_from" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="note_id" id="input_id">
                            <div class="modal-header">
                                <h4 id="modal_title" class="modal-title">اضافة ملاحظة</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <div class="col-md-12">
                                        <label for="">نص الملاحظة</label>
                                        <textarea required class="form-control" name="note_text" id="note_text" cols="30" rows="4" placeholder="يرجى كتابة الملاحظة"></textarea>
                                    </div>
                                    {{-- <div class="col-md-12">
                                        <label for="">تاريخ التنبيه</label>
                                        <input required name="alert_date" type="date" class="form-control text-center">
                                    </div> --}}

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

        $(document).ready(function() {
            showLoader();
            getOrderTable();
        });
        function getOrderTable(){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });

            $.ajax({
                url: '{{ url('users/procurement_officer/orders/order_table') }}',
                method: 'post',
                data:{
                    'search_order_number':document.getElementById('search_order_number').value
                },
                success: function (data) {
                    $('#order_table').html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                complete: function() {
                    // إخفاء شاشة التحميل بعد انتهاء استدعاء البيانات
                    hideLoader();
                }
            });
        }

        function openModalForEdit(model_name,note_id,note){
            // var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });
            if(model_name == 'anchor'){
                document.getElementById('input_id').value = note_id;
                document.getElementById('modal_title').innerHTML = 'تعديل ملاحظة ترسية'
                document.getElementById('note_text').value = note;
                document.getElementById('modal_from').action = "{{ route('procurement_officer.orders.notes.edit_note') }}";
                $('#modals-lg-edit').modal('show')
            }

            if(model_name == 'price_offer'){
                document.getElementById('input_id').value = note_id;
                document.getElementById('modal_title').innerHTML = 'تعديل ملاحظة عرض سعر'
                document.getElementById('note_text').value = note;
                document.getElementById('modal_from').action = "{{ route('procurement_officer.orders.notes.edit_price_offer_note') }}";
                $('#modals-lg-edit').modal('show')
            }

            if(model_name == 'cash_payment'){
                document.getElementById('input_id').value = note_id;
                document.getElementById('modal_title').innerHTML = 'تعديل ملاحظة الدفع النقدية'
                document.getElementById('note_text').value = note;
                document.getElementById('modal_from').action = "{{ route('procurement_officer.orders.notes.edit_cash_payment_note') }}";
                $('#modals-lg-edit').modal('show')
            }

            if(model_name == 'letter_bank'){
                document.getElementById('input_id').value = note_id;
                document.getElementById('modal_title').innerHTML = 'تعديل ملاحظة الاعتماد البنكي'
                document.getElementById('note_text').value = note;
                document.getElementById('modal_from').action = "{{ route('procurement_officer.orders.notes.edit_letter_bank_note') }}";
                $('#modals-lg-edit').modal('show')
            }

            if(model_name == 'letter_bank_modification'){
                document.getElementById('input_id').value = note_id;
                document.getElementById('modal_title').innerHTML = 'تعديل ملاحظة تمديد الاعتماد البنكي'
                document.getElementById('note_text').value = note;
                document.getElementById('modal_from').action = "{{ route('procurement_officer.orders.notes.edit_letter_bank_modification_note') }}";
                $('#modals-lg-edit').modal('show')
            }

            if(model_name == 'shipping'){
                document.getElementById('input_id').value = note_id;
                document.getElementById('modal_title').innerHTML = 'تعديل ملاحظة الشحن'
                document.getElementById('note_text').value = note;
                document.getElementById('modal_from').action = "{{ route('procurement_officer.orders.notes.edit_shipping_note') }}";
                $('#modals-lg-edit').modal('show')
            }

            if(model_name == 'insurance'){
                document.getElementById('input_id').value = note_id;
                document.getElementById('modal_title').innerHTML = 'تعديل ملاحظة التأمين'
                document.getElementById('note_text').value = note;
                document.getElementById('modal_from').action = "{{ route('procurement_officer.orders.notes.edit_insurance_note') }}";
                $('#modals-lg-edit').modal('show')
            }

            if(model_name == 'clearance'){
                document.getElementById('input_id').value = note_id;
                document.getElementById('modal_title').innerHTML = 'تعديل ملاحظة التخليص'
                document.getElementById('note_text').value = note;
                document.getElementById('modal_from').action = "{{ route('procurement_officer.orders.notes.edit_clearance_note') }}";
                $('#modals-lg-edit').modal('show')
            }

            if(model_name == 'delivery'){
                document.getElementById('input_id').value = note_id;
                document.getElementById('modal_title').innerHTML = 'تعديل ملاحظة التوصيل'
                document.getElementById('note_text').value = note;
                document.getElementById('modal_from').action = "{{ route('procurement_officer.orders.notes.edit_delivery_note') }}";
                $('#modals-lg-edit').modal('show')
            }

            if(model_name == 'order_notes'){
                document.getElementById('input_id').value = note_id;
                document.getElementById('modal_title').innerHTML = 'تعديل ملاحظة الطلبية'
                document.getElementById('note_text').value = note;
                document.getElementById('modal_from').action = "{{ route('procurement_officer.orders.notes.edit_order_notes_note') }}";
                $('#modals-lg-edit').modal('show')
            }

            // $.ajax({
            //     url: '{{ url('users/procurement_officer/orders/order_table') }}',
            //     method: 'post',
            //     data:{
            //         'search_order_number':document.getElementById('search_order_number').value
            //     },
            //     success: function (data) {
            //         $('#order_table').html(data);
            //     },
            //     error: function (jqXHR, textStatus, errorThrown) {
            //         alert(errorThrown);
            //     },
            //     complete: function() {
            //         // إخفاء شاشة التحميل بعد انتهاء استدعاء البيانات
            //         hideLoader();
            //     }
            // });
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

