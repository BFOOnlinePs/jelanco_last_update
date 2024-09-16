@extends('home')
@section('title')
    الملف المالي
@endsection
@section('header_title')
    <span>الملف المالي <span>@if($order->reference_number != 0)
                #{{ $order->reference_number }}
            @endif</span></span>
@endsection
@section('header_link')
    طلبات الشراء
@endsection
@section('header_title_link')
    الملف المالي
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
    @include('admin.orders.order_menu')
    <div class="card">

        <div class="card-header">
            <h5 class="text-center">الدفع النقدية</h5>
        </div>

        <div class="card-body">
            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modal-cash_payment">
                <span class="fa fa-plus"></span>
                اضافة دفعة
            </button>
            <div class="row mt-3">
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered text-center">
                        <thead class="bg-dark">
                        <tr>
                            <th>المبلغ</th>
                            <th>النسبة</th>
                            <th>تاريخ الاستحقاق</th>
                            <th>نوع الدفعة</th>
                            <th>العملة</th>
                            <th>حالة الدفعة</th>
                            {{--                            <th>تاريخ الدفع</th>--}}
                            {{--                            <th>الملاحظات</th>--}}
                            <th>المرفقات</th>
                            {{--                            <th>بواسطة</th>--}}
                            {{--                            <th>تاريخ الادخال</th>--}}
                            <th>العمليات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($cash_payment->isEmpty())
                            <tr>
                                <td class="text-center" colspan="7">لا توجد بيانات</td>
                            </tr>
                        @endif
                        @foreach($cash_payment as $key)
                            <tr class="">
                                <td>{{ $key->amount }}</td>
                                <td>{{ $key->persent }}%</td>
                                <td>{{ $key->due_date }}</td>
                                <td class="@if($key->payment_type == 2) bg-warning @endif">
                                    @if($key->payment_type == 1)
                                        نقدية
                                    @else
                                        مؤجلة
                                    @endif
                                </td>
                                <td>{{ $key['currency']->currency_name ?? '' }}</td>
                                <td>
                                    <span class="@if($key->payment_status == 0) bg-danger @elseif($key->payment_status == 1) bg-success @endif p-1">
                                        @if($key->payment_status == 0)
                                            بانتظار الدفع
                                        @elseif($key->payment_status == 1)
                                            مدفوعة
                                        @endif
                                    </span>
{{--                                    <select onchange="updatePaymentStatus({{ $key->id }},this.value,{{ $loop->index }})"--}}
{{--                                            style="height: 30px;width: 150px"--}}
{{--                                            class="@if($key->payment_status == 0) bg-danger @elseif($key->payment_status == 1) bg-success @endif"--}}
{{--                                            name="payment_status" id="payment_status_{{$loop->index}}">--}}
{{--                                        <option @if($key->payment_status == 0) selected @endif value="0">بانتظار الدفع--}}
{{--                                        </option>--}}
{{--                                        <option @if($key->payment_status == 1) selected @endif value="1">مدفوعة</option>--}}
{{--                                    </select>--}}
                                </td>
                                <td>
                                    @if(empty($key->attachment))
                                        لا يوجد ملف
                                    @else
                                        <a type="text"
                                           href="{{ asset('storage/attachment/'.$key->attachment) }}"
                                           download="{{ $key->attachment }}" class="btn btn-primary btn-sm"><span
                                                class="fa fa-download"></span></a>
                                        <button
                                            onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->attachment) }}',null)"
                                            href="" class="btn btn-success btn-sm" data-toggle="modal"
                                            data-target="#modal-lg-view_attachment"><span
                                                class="fa fa-search"></span></button>
                                    @endif
                                </td>
                                <td>
                                    <div style="float: left">
                                        <a href="{{ route('procurement_officer.orders.financial_file.edit_cash_payment',['id'=>$key->id]) }}"
                                           class="btn btn-sm btn-success"><i class="fa fa-edit mt-1"></i></a>
                                        <a href="{{ route('procurement_officer.orders.financial_file.delete_cash_payment',['id'=>$key->id]) }}"
                                           onclick="return confirm('لا يمكن استرجاع الباينات هل انت متاكد من حذفها ؟')"
                                           class="btn btn-sm btn-danger"><i class="fa fa-trash mt-1"></i></a>
                                        @if($key->payment_status == 0)
                                            <button onclick="get_cash_payment_id({{ $key->id }})" type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#payment_status">
                                                دفع
                                            </button>
                                            {{--                                        <a href="{{ route('procurement_officer.orders.financial_file.update_payment_status',['id'=>$key->id]) }}" onclick="return confirm('هل انت متاكد من عملية الدفع ؟')" class="btn btn-dark btn-sm">دفع</a>--}}
                                        @endif
                                    </div>

                                </td>
                            </tr>
                            @if(!empty($key->payment_date))
                                <tr>
                                    <td colspan="2"></td>

                                    <td colspan="10" class="bg-secondary" style="text-align: right!important">
                                        <span>
                                            <form style="display: inline" action="{{ route('procurement_officer.orders.financial_file.delete_payment_status') }}" method="post">
                                                @csrf
                                                <input type="hidden" value="{{ $order->id }}" name="order_id">
                                                <input type="hidden" value="{{ $key->id }}" name="id">
                                                <button onclick="return confirm('هل تريد حذف الدفعة ؟')" style="background: none;padding: 0;border: none" type="submit"><span class="fa fa-trash text-white" title="حذف الدفعة"></span></button>
                                            </form>
                                        </span>
                                        |
                                        <span>
                                            <button onclick="get_data_for_payment_date('{{ $key->id }}','{{ $key->payment_date }}','{{ $key->payment_voucher_attachment??'' }}','{{ $key->payment_voucher_note??'' }}')" data-toggle="modal" data-target="#edit_payment_status" style="background: none;padding: 0;border: none" href=""><span class="fa fa-edit text-white"></span></button>
                                        </span>
                                        @if(!empty($key->payment_voucher_attachment))
                                            <span>
                                            <a type="text"
                                               href="{{ asset('storage/attachment/'.$key->payment_voucher_attachment) }}"
                                               download="{{ $key->payment_voucher_attachment }}" class="text-white"><span
                                                    class="fa fa-download"></span></a>
                                            |
                                        <a
                                            onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->payment_voucher_attachment) }}',null)"
                                            href="" class="text-white" data-toggle="modal"
                                            data-target="#modal-lg-view_attachment"><span
                                                class="fa fa-search"></span></a>
                                        </span>
                                        @endif
                                        |
                                        <span class="pr-4">
                                            تم دفع الفاتورة بتاريخ <span>{{ $key->payment_date }}</span>
                                        </span>
                                        |
                                        <span>
                                            @if(empty($key->payment_voucher_note))
                                                لا توجد ملاحظات
                                            @else
                                                {{ $key->payment_voucher_note }}
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="text-center">الاعتمادات البنكية</h5>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modal-letter_bank">
                <span class="fa fa-plus"></span>
                اضافة اعتماد بنكي
            </button>

            <div class="row mt-3">
                <div class="table-responsive">
                    <table class="table-bordered table-hover" width="100%">
                        <thead class="bg-dark">
                        <tr>
                            <th>نوع الاعتماد</th>
                            <th>قيمة الاعتماد</th>
                            <th>العملة</th>
                            <th>اسم البنك</th>
                            <th>تاريخ الاستحقاق</th>
                            <th>حالة الاعتماد</th>
                            <th>المرفقات</th>
                            <th>العمليات</th>
                        </tr>
                        </thead>
                        <tbody class="">
                        @if($letter_bank->isEmpty())
                            <tr>
                                <td class="text-center" colspan="7">لا توجد بيانات</td>
                            </tr>
                        @endif
                        @foreach($letter_bank as $key)
                            <tr class="">
                                <td>
                                    @if($key->letter_type == 1)
                                        اعتماد دفع
                                    @elseif($key->letter_type == 2)
                                        اعتماد من الطلب
                                    @endif
                                </td>
                                <td>{{ $key->letter_value }}</td>
                                <td>{{ $key['currency']->currency_name ?? '' }}</td>
                                <td>{{ $key['bank_name']->user_bank_name }}</td>
                                <td>{{ $key->due_date }}</td>
                                <td>
                                    <span class="@if($key->status == 0) bg-danger @elseif($key->status == 1) bg-success @endif p-1">
                                        @if($key->status == 0)
                                            بانتظار الدفع
                                        @elseif($key->status == 1)
                                            مدفوعة
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    @if(empty($key->attachment))
                                        لا يوجد ملف
                                    @else
                                        <a type="text"
                                           href="{{ asset('storage/attachment/'.$key->attachment) }}"
                                           download="{{ $key->attachment }}" class="btn btn-primary btn-sm"><span
                                                class="fa fa-download"></span></a>
                                        <button
                                            onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->attachment) }}',null)"
                                            href="" class="btn btn-success btn-sm" data-toggle="modal"
                                            data-target="#modal-lg-view_attachment"><span
                                                class="fa fa-search"></span></button>
                                    @endif
                                </td>
                                {{--                                <td>{{ $key->status }}</td>--}}
                                <td>
                                    <div style="float: left">
                                        <a href="{{ route('procurement_officer.orders.financial_file.edit_letter_bank',['id'=>$key->id]) }}"
                                           class="btn btn-sm btn-success"><i class="fa fa-edit mt-1"></i></a>
                                        <a href="{{ route('procurement_officer.orders.financial_file.delete_letter_bank',['id'=>$key->id]) }}"
                                           onclick="return confirm('لا يمكن استرجاع الباينات هل انت متاكد من حذفها ؟')"
                                           class="btn btn-sm btn-danger"><i class="fa fa-trash mt-1"></i></a>
                                        <button onclick="getLetterBankId({{ $key->id }})" class="btn btn-sm btn-dark"
                                                data-toggle="modal" data-target="#modal-extension_modification">تمديد اعتماد
                                        </button>
                                        @if($key->status == 0)
                                            <button onclick="get_paid_letter_bank_id({{ $key->id }})" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#paid_letter_bank">دفع</button>
{{--                                            <form style="display: inline" action="{{ route('procurement_officer.orders.financial_file.paid_letter_bank') }}" method="post">--}}
{{--                                                @csrf--}}
{{--                                                <input type="hidden" name="id" value="{{ $key->id }}">--}}
{{--                                                <button onclick="return confirm('هل انت متاكد من عملية الدفع ؟')" type="submit" class="btn btn-warning btn-sm">--}}
{{--                                                    دفع--}}
{{--                                                </button>--}}
{{--                                            </form>--}}
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @if($key->status == 1)
                                <td colspan="8" class="bg-secondary" style="text-align: right!important">
                                        <span>
                                            <form style="display: inline" action="{{ route('procurement_officer.orders.financial_file.delete_paid_letter_bank') }}" method="post">
                                                @csrf
                                                <input type="hidden" value="{{ $order->id }}" name="order_id">
                                                <input type="hidden" value="{{ $key->id }}" name="id">
                                                <button onclick="return confirm('هل تريد حذف الدفعة ؟')" style="background: none;padding: 0;border: none" type="submit"><span class="fa fa-trash text-white" title="حذف الدفعة"></span></button>
                                            </form>
                                        </span>
                                    |
                                    <span>
                                            <button onclick="get_data_for_paid_letter_bank('{{ $key->id }}','{{ $key->paid_date }}','{{ $key->paid_attachment??'' }}','{{ $key->paid_notes??'' }}')" data-toggle="modal" data-target="#edit_paid_letter_bank" style="background: none;padding: 0;border: none" href=""><span class="fa fa-edit text-white"></span></button>
                                        </span>
                                    @if(!empty($key->paid_attachment))
                                        <span>
                                            <a type="text"
                                               href="{{ asset('storage/letter_bank/'.$key->paid_attachment) }}"
                                               download="{{ $key->paid_attachment }}" class="text-white"><span
                                                    class="fa fa-download"></span></a>
                                            |
                                        <a
                                            onclick="viewAttachment({{ $key->id }},'{{ asset('storage/letter_bank/'.$key->paid_attachment) }}',null)"
                                            href="" class="text-white" data-toggle="modal"
                                            data-target="#modal-lg-view_attachment"><span
                                                class="fa fa-search"></span></a>
                                        </span>
                                    @endif
                                    |
                                    <span class="pr-4">
                                            تم دفع الفاتورة بتاريخ <span>{{ $key->paid_date }}</span>
                                        </span>
                                    |
                                    <span>
                                            @if(empty($key->paid_notes))
                                            لا توجد ملاحظات
                                        @else
                                            {{ $key->paid_notes }}
                                        @endif
                                        </span>
                                </td>

                        @endif
                        @if(!$key->modifications->isEmpty())
                            <thead class="">
                                <tr class=" bg-info">
                                    <th colspan="1" class="bg-warning"></th>
                                    <th>تاريخ الاستحقاق</th>
                                    <th>ملاحظات</th>
                                    <th>الملف</th>
                                    <th>اضافة بواسطة</th>
                                    <th colspan="2"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($letter_bank->isEmpty())
                                <tr>
                                    <td colspan="7"></td>
                                </tr>
                            @endif
                            @foreach($key->modifications as $child)
                                <tr class="">
                                    <td colspan="1">تمديد اعتماد بنكي</td>
                                    <td>{{ $child->new_due_date }}</td>
                                    <td>{{ $child->notes }}</td>
                                    <td>
                                        @if(empty($child->attachment))
                                            لا يوجد ملف
                                        @else
                                            <a type="text"
                                               href="{{ asset('storage/attachment/'.$child->attachment) }}"
                                               download="{{ $child->attachment }}" class="btn btn-primary btn-sm"><span class="fa fa-download"></span></a>
                                            <button type="button" onclick="viewAttachment({{ $child->id }},'{{ asset('storage/attachment/'.$child->attachment) }}',null)" href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                    data-target="#modal-lg-view_attachment"><span
                                                    class="fa fa-search"></span></button>
                                        @endif
                                    </td>
                                    <td>{{ \App\Models\User::where('id',$child->insert_by)->value('name') }}</td>
                                    <td colspan="2" class="text-right">
                                        <a href="{{ route('procurement_officer.orders.financial_file.edit_extension',['id'=>$child->id]) }}"
                                           class="btn btn-success btn-sm"><span class="fa fa-edit mt-1"></span></a>
                                        <a href="{{ route('procurement_officer.orders.financial_file.delete_extension',['id'=>$child->id]) }}"
                                           class="btn btn-danger btn-sm" on
                                           onclick="return confirm('هل تريد حذف تمديد الاعتماد ؟')"><span
                                                class="fa fa-trash mt-1"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
{{--                            <tr>--}}
{{--                                <td colspan="7">--}}
{{--                                    <hr>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
                            </tbody>

                            @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-cash_payment">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('procurement_officer.orders.financial_file.create_cash_payment') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة دفعة</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">نوع الدفعة</label>
                                    <select required class="form-control" name="payment_type" id="">
                                        <option selected value="">اختر نوع الدفعة ..</option>
                                        <option value="1">نقدية</option>
                                        <option value="2">مؤجلة</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">المبلغ</label>
                                    <input required name="amount" class="form-control" type="text" placeholder="المبلغ">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">النسبة</label>
                                    <input required name="persent" class="form-control" type="text"
                                           placeholder="النسبة">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">تاريخ الدفعة</label>
                                    <input required name="due_date" class="form-control date_format" type="text"
                                           placeholder="تاريخ الدفعة">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">حالة الدفعة</label>
                                    <select required class="form-control" name="payment_status" id="">
                                        <option value="">اختر حالة الدفعة ..</option>
                                        <option value="0">غير مدفوعة</option>
                                        <option value="1">مدفوعة</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">العملة</label>
                                    <select class="form-control" name="currency_id" id="">
                                        @foreach($currency as $key)
                                            <option value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div hidden class="col-md-6">
                                <div class="form-group">
                                    <label for="">تاريخ الدفع</label>
                                    <input name="payment_date" class="form-control date_format" type="text"
                                           placeholder="تاريخ الدفع">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">مرفقات</label>
                                <input name="attachment" class="form-control" type="file">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">ملاحظات</label>
                                    <textarea class="form-control" placeholder="ملاحظات" name="notes" id="" cols="30"
                                              rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
    <div class="modal fade" id="modal-letter_bank">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('procurement_officer.orders.financial_file.create_letter_bank') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة اعتماد بنكي</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">نوع الاعتماد</label>
                                    <select required class="form-control" name="letter_type" id="">
                                        <option value="1">اعتماد دفع</option>
                                        <option value="2">اعتماد حين الطلب</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">قيمة الاعتماد</label>
                                    <input required name="letter_value" class="form-control" type="text"
                                           placeholder="قيمة الاعتماد">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">البنك</label>
                                    <select required name="bank_id" class="select2bs4" id="">
                                        @foreach($banks as $key)
                                            <option value="{{ $key->id }}">{{ $key->user_bank_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">المدة باليوم</label>
                                    <input required onkeyup="calculateDueDate(this.value)" name="duration_days"
                                           class="form-control" type="number"
                                           placeholder="المدة باليوم">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">تاريخ الاستحقاق</label>
                                    <input required id="due_date" name="due_date" class="form-control date_format"
                                           type="text"
                                           placeholder="تاريخ الاستحقاق">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">العملة</label>
                                    <select name="currency_id" class="form-control" id="">
                                        @foreach($currency as $key)
                                            <option value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">المرفقات</label>
                                    <input name="attachment" type="file" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">الملاحظات</label>
                                    <textarea name="notes" class="form-control" placeholder="الملاحظات" id="" cols="30"
                                              rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="modal-extension_modification">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('procurement_officer.orders.financial_file.create_extension') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="input_letter_bank_id" name="letter_bank_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة دفعة</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">تاريخ الاستحقاق</label>
                                    <input type="text" name="new_due_date" required placeholder="تاريخ الاستحقاق"
                                           class="form-control date_format">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">الملف</label>
                                    <input type="file" name="attachment" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">ملاحظات</label>
                                    <textarea class="form-control" placeholder="ملاحظات" name="notes" id="" cols="30"
                                              rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <div class="text-center">
        <p>تم انشاء هذه الطلبية بواسطة <span class="text-danger text-bold">{{ $order['user']->name ?? '' }}</span> ويتم متابعتها بواسطة <span class="text-danger text-bold">{{ $order['to_user']->name ?? '' }}</span></p>
    </div>

    <div class="modal fade" id="payment_status">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('procurement_officer.orders.financial_file.update_payment_status') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <input type="hidden" name="cash_payment_id" id="cash_payment_id">
                    <h4 class="modal-title">الدفع</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">تاريخ الدفع</label>
                                <input value="@php echo date('Y-m-d') @endphp" name="payment_date" type="date" class="form-control text-left">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="">مرفقات</label>
                            <input type="file" class="form-control" name="payment_voucher_attachment">
                        </div>
                        <div class="col-md-12">
                            <label for="">ملاحظات</label>
                            <textarea name="payment_voucher_note" class="form-control" id="" cols="30" rows="3"></textarea>
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

    <div class="modal fade" id="edit_payment_status">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('procurement_officer.orders.financial_file.update_payment_status') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <input type="hidden" name="cash_payment_id" id="cash_payment_id_status">
                    <h4 class="modal-title">تعديل الدفعة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">تاريخ الدفع</label>
                                <input value="@php echo date('Y-m-d') @endphp" name="payment_date" id="payment_date" type="date" class="form-control text-left">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="">مرفقات</label>
                            <input type="file" class="form-control" id="" name="payment_voucher_attachment">
                        </div>
                        <div class="col-md-12">
{{--                            <a id="payment_voucher_attachment_a" type="text"--}}
{{--                               href="{{ asset('storage/attachment/'.$child->attachment) }}"--}}
{{--                               download="attachment" class="btn btn-primary btn-sm"><span class="fa fa-download"></span></a>--}}
{{--                            <button id="payment_voucher_attachment_button" type="button" onclick="viewAttachment('{{ asset('storage/attachment/'.$child->attachment) }}')" class="btn btn-success btn-sm" data-toggle="modals"--}}
{{--                                    data-target="#modals-lg-view_attachment"><span--}}
{{--                                    class="fa fa-search"></span></button>--}}
                        </div>
                        <div class="col-md-12">
                            <label for="">ملاحظات</label>
                            <textarea name="payment_voucher_note" class="form-control" id="notes" cols="30" rows="3"></textarea>
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
    <div class="modal fade" id="paid_letter_bank">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('procurement_officer.orders.financial_file.paid_letter_bank') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="letter_bank_paid_id" name="id">
                    <div class="modal-header">
                    <h4 class="modal-title">دفع الاعتماد البنكي</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">تاريخ الدفع</label>
                                <input value="@php echo date('Y-m-d') @endphp" name="paid_date" id="payment_date" type="date" class="form-control text-left">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="">مرفقات</label>
                            <input type="file" class="form-control" id="" name="paid_attachment">
                        </div>
                        <div class="col-md-12">
                            <label for="">ملاحظات</label>
                            <textarea name="paid_notes" class="form-control" id="notes" cols="30" rows="3"></textarea>
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
    <div class="modal fade" id="edit_paid_letter_bank">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('procurement_officer.orders.financial_file.update_paid_letter_bank') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="edit_letter_bank_paid_id" name="id">
                    <div class="modal-header">
                    <h4 class="modal-title">دفع الاعتماد البنكي</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">تاريخ الدفع</label>
                                <input value="@php echo date('Y-m-d') @endphp" name="paid_date" id="paid_date" type="date" class="form-control text-left">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="">مرفقات</label>
                            <input type="file" class="form-control" id="" name="paid_attachment">
                        </div>
                        <div class="col-md-12">
                            <label for="">ملاحظات</label>
                            <textarea name="paid_notes" class="form-control" id="paid_notes" cols="30" rows="3"></textarea>
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
        function calculateDueDate(durationInDays) {
            const currentDate = new Date(); // Get the current date
            const dueDate = new Date(currentDate.getTime() + durationInDays * 24 * 60 * 60 * 1000); // Add duration in milliseconds
            const year = dueDate.getFullYear();
            const month = String(dueDate.getMonth() + 1).padStart(2, '0');
            const day = String(dueDate.getDate()).padStart(2, '0');
            const formattedDueDate = `${year}-${month}-${day}`;
            document.getElementById('due_date').value = formattedDueDate;
        }

        function updatePaymentStatus(id, payment_status, index) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('procurement_officer.orders.financial_file.updatePaymentStatus') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'payment_status': payment_status,
                },
                success: function (data) {
                    var element = document.getElementById('payment_status_' + index);
                    if (data.success == 'true') {
                        if (payment_status == 0) {
                            element.classList.remove('bg-success');
                            element.classList.add('bg-danger');
                        } else if (payment_status == 1) {
                            element.classList.remove('bg-danger');
                            element.classList.add('bg-success');
                        }
                    }
                    toastr.success('تم تعديل حالة الطلبية بنجاح')
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function get_cash_payment_id(cash_payment_id) {
            document.getElementById('cash_payment_id').value = cash_payment_id;
        }

        function getLetterBankId(id) {
            document.getElementById('input_letter_bank_id').value = id;
        }

        function get_data_for_payment_date(cash_payment_id,payment_date,file,notes){
            document.getElementById('cash_payment_id_status').value = cash_payment_id;
            document.getElementById('payment_date').value = payment_date;
            document.getElementById('payment_voucher_attachment_a').href = '{{ asset('storage/attachment/') }}'+'/'+file;
            document.getElementById('payment_voucher_attachment_button').onclick = viewAttachment('{{ asset('storage/attachment/') }}'+'/'+file);
            document.getElementById('notes').value = notes;
        }

        function get_paid_letter_bank_id(id) {
            document.getElementById('letter_bank_paid_id').value = id;
        }

        function get_data_for_paid_letter_bank(letter_bank_id,paid_date,file,paid_notes){
            document.getElementById('edit_letter_bank_paid_id').value = letter_bank_id;
            document.getElementById('paid_date').value = paid_date;
            document.getElementById('paid_notes').value = paid_notes;
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

