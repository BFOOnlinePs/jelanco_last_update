@extends('home')
@section('title')
    مرفقات
@endsection
@section('header_title')
    <span>مرفقات <span>@if($order->reference_number != 0)
                #{{ $order->reference_number }}
            @endif</span></span>
@endsection
@section('header_link')
    طلبات الشراء
@endsection
@section('header_title_link')
    مرفقات
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
            <h3 class="text-center">المرفقات</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <button type="button" class="btn btn-dark mb-2" data-toggle="modal"
                        data-target="#modal-lg-order_attachment">اضافة مرفق
                </button>
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>الفئة</th>
                            <th>الوصف</th>
                            <th>الملف</th>
                            <th>تاريخ الاضافة</th>
                            <th>الملاحظات</th>
                            <th>العمليات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$order_attachment->isEmpty())
                            @foreach($order_attachment as $key)
                                @if($key->target == 'order_product')
                                    @if(!empty($key->attachment))
                                        <tr>
                                            <td>مرفقات</td>
                                            <td>
                                                قائمة الاصناف
                                            </td>
                                            <td>
                                                <a type="text"
                                                   href="{{ asset('storage/attachment/'.$key->attachment) }}"
                                                   download="{{ $key->attachment }}" class="btn btn-primary btn-sm"><span
                                                        class="fa fa-download"></span></a>
                                                <button
                                                    onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->attachment) }}',null)"
                                                    href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                    data-target="#modal-lg-view_attachment"><span
                                                        class="fa fa-search"></span></button>
                                            </td>
                                            <td>
                                                {{ $key->insert_at }}
                                            </td>
                                            <td> {{ $key->notes }}</td>
                                            <td>
{{--                                                <a href="" class="btn btn-sm btn-success"><span class="fa fa-edit"></span></a>--}}
                                                <a onclick="return confirm('هل انت متاكد من عملية حذف المرفق ؟')" class="btn btn-danger btn-sm" href="{{ route('procurement_officer.orders.attachment.delete_order_attachment',['id'=>$key->id]) }}"><span class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                @else
                                    @if(!empty($key->attachment))
                                        <tr>
                                            <td>مرفقات</td>
                                            <td>
                                                مرفقات تم تحميلها
                                            </td>
                                            <td>
                                                <a type="text"
                                                   href="{{ asset('storage/attachment/'.$key->attachment) }}"
                                                   download="{{ $key->attachment }}" class="btn btn-primary btn-sm"><span
                                                        class="fa fa-download"></span></a>
                                                <button
                                                    onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->attachment) }}',null)"
                                                    href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                    data-target="#modal-lg-view_attachment"><span
                                                        class="fa fa-search"></span></button>
                                            </td>
                                            <td>
                                                {{ $key->insert_at }}
                                            </td>
                                            <td> {{ $key->notes }}</td>
                                            <td>
{{--                                                <a href="" class="btn btn-sm btn-success"><span class="fa fa-edit"></span></a>--}}
                                                <a onclick="return confirm('هل انت متاكد من عملية حذف المرفق ؟')" class="btn btn-danger btn-sm" href="{{ route('procurement_officer.orders.attachment.delete_order_attachment',['id'=>$key->id]) }}"><span class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                        @if(!$shipping->isEmpty())
                            @foreach($shipping as $key)
                                @if(!empty($key->attachment))
                                    <tr>
                                        <td>الشحن</td>
                                        <td>
                                            عرض سعر - <span>{{ $key['shipping_company']->name }}</span>
                                        </td>
                                        <td>
                                            <a type="text"
                                               href="{{ asset('storage/attachment/'.$key->attachment) }}"
                                               download="{{ $key->attachment }}" class="btn btn-primary btn-sm"><span
                                                    class="fa fa-download"></span></a>
                                            <button
                                                onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->attachment) }}',null)"
                                                href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view_attachment"><span
                                                    class="fa fa-search"></span></button>
                                        </td>
                                        <td>
                                            {{ $key->created_at }}
                                        </td>
                                        <td> {{ $key->notes }}</td>
                                        <td>
                                            <a onclick="return confirm('هل انت متاكد من عملية حذف المرفق ؟')" class="btn btn-danger btn-sm" href="{{ route('procurement_officer.orders.attachment.delete_order_attachment',['id'=>$key->id]) }}"><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                        @if(!$shipping_award->isEmpty())
                            @foreach($shipping_award as $key)
                                @if(!empty($key->Initial_bill_of_lading))
                                    <tr>
                                        <td>ترسية شحن</td>
                                        <td>
                                            بوليصة شحن اولية
                                        </td>
                                        <td>
                                            <a type="text"
                                               href="{{ asset('storage/attachment/'.$key->Initial_bill_of_lading) }}"
                                               download="{{ $key->Initial_bill_of_lading }}" class="btn btn-primary btn-sm"><span
                                                    class="fa fa-download"></span></a>
                                            <button
                                                onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->Initial_bill_of_lading) }}',null)"
                                                href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view_attachment"><span
                                                    class="fa fa-search"></span></button>
                                        </td>
                                        <td>
                                            {{ $key->created_at }}
                                        </td>
                                        <td> {{ $key->notes }}</td>
                                        <td>
                                            <a class="btn btn-danger btn-sm" href=""><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($key->actual_bill_of_lading))
                                    <tr>
                                        <td>ترسية شحن</td>
                                        <td>
                                            بوليصة شحن فعلية
                                        </td>
                                        <td>
                                            <a type="text"
                                               href="{{ asset('storage/attachment/'.$key->actual_bill_of_lading) }}"
                                               download="{{ $key->actual_bill_of_lading }}" class="btn btn-primary btn-sm"><span
                                                    class="fa fa-download"></span></a>
                                            <button
                                                onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->actual_bill_of_lading) }}',null)"
                                                href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view_attachment"><span
                                                    class="fa fa-search"></span></button>
                                        </td>
                                        <td>
                                            {{ $key->created_at }}
                                        </td>
                                        <td> {{ $key->notes }}</td>
                                        <td>
                                            <a onclick="return confirm('هل انت متاكد من عملية حذف المرفق ؟')" class="btn btn-danger btn-sm" href="{{ route('procurement_officer.orders.attachment.delete_order_attachment',['id'=>$key->id]) }}"><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                        @if(!$price_offer->isEmpty())
                            @foreach($price_offer as $key)
                                @if(!empty($key->attachment))

                                    <tr>
                                        <td>طلبية</td>
                                        <td>
                                            عرض سعر - <span>{{ $key['supplier']->name }}</span>
                                        </td>
                                        <td>
                                            <a type="text"
                                               href="{{ asset('storage/attachment/'.$key->attachment) }}"
                                               download="{{ $key->attachment }}" class="btn btn-primary btn-sm"><span
                                                    class="fa fa-download"></span></a>
                                            <button
                                                onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->attachment) }}',null)"
                                                href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view_attachment"><span
                                                    class="fa fa-search"></span></button>
                                        </td>
                                        <td>
                                            {{ $key->created_at }}
                                        </td>
                                        <td> {{ $key->notes }}</td>
                                        <td>
                                            <a onclick="return confirm('هل انت متاكد من عملية حذف المرفق ؟')" class="btn btn-danger btn-sm" href="{{ route('procurement_officer.orders.attachment.delete_order_attachment',['id'=>$key->id]) }}"><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                        @if(!$anchor->isEmpty())
                            @foreach($anchor as $key)
                                @if(!empty($key->award_attachment))
                                    <tr>
                                        <td>ترسية</td>
                                        <td>
                                            ترسية - <span>{{ $key['supplier']->name }}</span>
                                        </td>
                                        <td>
                                            <a type="text"
                                               href="{{ asset('storage/award_attachment/'.$key->award_attachment) }}"
                                               download="{{ $key->award_attachment }}" class="btn btn-primary btn-sm"><span
                                                    class="fa fa-download"></span></a>
                                            <button
                                                onclick="viewAttachment({{ $key->id }},'{{ asset('storage/award_attachment/'.$key->award_attachment) }}',null)"
                                                href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view_attachment"><span
                                                    class="fa fa-search"></span></button>
                                        </td>
                                        <td>
                                            {{ $key->created_at }}
                                        </td>
                                        <td> {{ $key->notes }}</td>
                                        <td>
                                            <a onclick="return confirm('هل انت متاكد من عملية حذف المرفق ؟')" class="btn btn-danger btn-sm" href="{{ route('procurement_officer.orders.attachment.delete_order_attachment',['id'=>$key->id]) }}"><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                        @if(!$letter_bank->isEmpty())
                            @foreach($letter_bank as $key)
                                @if(!empty($key->attachment))
                                    <tr>
                                        <td>الاعتماد البنكي</td>
                                        <td>
                                            اعتماد بنكي في <span>{{ $key['bank']->user_bank_name }}</span>
                                        </td>
                                        <td>
                                            <a type="text"
                                               href="{{ asset('storage/attachment/'.$key->attachment) }}"
                                               download="{{ $key->attachment }}" class="btn btn-primary btn-sm"><span
                                                    class="fa fa-download"></span></a>
                                            <button
                                                onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->attachment) }}',null)"
                                                href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view_attachment"><span
                                                    class="fa fa-search"></span></button>
                                        </td>
                                        <td>
                                            {{ $key->created_at }}
                                        </td>
                                        <td> {{ $key->notes }}</td>
                                        <td>
                                            <a class="btn btn-danger btn-sm" href=""><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                @endif
                                @foreach($key['letter_bank_modification'] as $child)
                                    @if(!empty($key['letter_bank_modification']))
                                        @if(!empty($child->attachment))
                                            <tr>
                                                <td>تمديد الاعتماد البنكي</td>
                                                <td>
                                                    تمديد اعتماد رقم - {{ $child->letter_bank_id }}
                                                </td>
                                                <td>
                                                    <a type="text"
                                                       href="{{ asset('storage/attachment/'.$child->attachment) }}"
                                                       download="{{ $child->attachment }}" class="btn btn-primary btn-sm"><span
                                                            class="fa fa-download"></span></a>
                                                    <button
                                                        onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$child->attachment) }}',null)"
                                                        href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                        data-target="#modal-lg-view_attachment"><span
                                                            class="fa fa-search"></span></button>
                                                </td>
                                                <td>
                                                    {{ $child->created_at }}
                                                </td>
                                                <td> {{ $child->notes }}</td>
                                                <td>
                                                    <a onclick="return confirm('هل انت متاكد من عملية حذف المرفق ؟')" class="btn btn-danger btn-sm" href="{{ route('procurement_officer.orders.attachment.delete_order_attachment',['id'=>$key->id]) }}"><span class="fa fa-trash"></span></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                            @endforeach
                        @endif
                        @if(!$cash_payments->isEmpty())
                            @foreach($cash_payments as $key)
                                @if(!empty($key->attachment))
                                    <tr>
                                        <td>الدفعات</td>
                                        <td>
                                            ملف الدفعة - <span>{{ $key->insert_at }}</span>
                                        </td>
                                        <td>
                                            <a type="text"
                                               href="{{ asset('storage/attachment/'.$key->attachment) }}"
                                               download="{{ $key->attachment }}" class="btn btn-primary btn-sm"><span
                                                    class="fa fa-download"></span></a>
                                            <button
                                                onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->attachment) }}',null)"
                                                href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view_attachment"><span
                                                    class="fa fa-search"></span></button>
                                        </td>
                                        <td>
                                            {{ $key->created_at }}
                                        </td>
                                        <td> {{ $key->notes }}</td>
                                        <td>
                                            <a onclick="return confirm('هل انت متاكد من عملية حذف المرفق ؟')" class="btn btn-danger btn-sm" href="{{ route('procurement_officer.orders.attachment.delete_order_attachment',['id'=>$key->id]) }}"><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($key->payment_voucher_attachment))
                                    <tr>
                                        <td>الدفعات</td>
                                        <td>
                                            دفع دفعة - <span>{{ $key->insert_at }}</span>
                                        </td>
                                        <td>
                                            <a type="text"
                                               href="{{ asset('storage/attachment/'.$key->payment_voucher_attachment) }}"
                                               download="{{ $key->payment_voucher_attachment }}" class="btn btn-primary btn-sm"><span
                                                    class="fa fa-download"></span></a>
                                            <button
                                                onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->payment_voucher_attachment) }}',null)"
                                                href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view_attachment"><span
                                                    class="fa fa-search"></span></button>
                                        </td>
                                        <td>
                                            {{ $key->created_at }}
                                        </td>
                                        <td> {{ $key->notes }}</td>
                                        <td>
                                            <a onclick="return confirm('هل انت متاكد من عملية حذف المرفق ؟')" class="btn btn-danger btn-sm" href="{{ route('procurement_officer.orders.attachment.delete_order_attachment',['id'=>$key->id]) }}"><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                        @if(!$insurance->isEmpty())
                            @foreach($insurance as $key)
                                @if(!empty($key->attachment))
                                    <tr>
                                        <td>التامين</td>
                                        <td>
                                            بوليصة تأمين بتاريخ - <span>{{ $key->insert_at }}</span>
                                        </td>
                                        <td>
                                            <a type="text"
                                               href="{{ asset('storage/attachment/'.$key->attachment) }}"
                                               download="{{ $key->attachment }}" class="btn btn-primary btn-sm"><span
                                                    class="fa fa-download"></span></a>
                                            <button
                                                onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->attachment) }}',null)"
                                                href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view_attachment"><span
                                                    class="fa fa-search"></span></button>
                                        </td>
                                        <td>
                                            {{ $key->created_at }}
                                        </td>
                                        <td> {{ $key->notes }}</td>
                                        <td>
                                            <a onclick="return confirm('هل انت متاكد من عملية حذف المرفق ؟')" class="btn btn-danger btn-sm" href="{{ route('procurement_officer.orders.attachment.delete_order_attachment',['id'=>$key->id]) }}"><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                        @if(!$clerance->isEmpty())
                            @foreach($clerance as $key)
                                @foreach($key['clerance_attachment'] as $child)
                                    @if(!empty($child->attachment_original))
                                        <tr>
                                            <td>التخليص</td>
                                            <td>
                                                {{ $child->clerance_attachemnt['type_name'] }} - اصلية
                                            </td>
                                            <td>
                                                <a type="text"
                                                   href="{{ asset('storage/attachment/'.$child->attachment_original) }}"
                                                   download="{{ $child->attachment_original }}" class="btn btn-primary btn-sm"><span
                                                        class="fa fa-download"></span></a>
                                                <button
                                                    onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$child->attachment_original) }}',null)"
                                                    href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                    data-target="#modal-lg-view_attachment"><span
                                                        class="fa fa-search"></span></button>
                                            </td>
                                            <td>
                                                {{ $child->created_at }}
                                            </td>
                                            <td> {{ $child->notes }}</td>
                                            <td>
                                                <a onclick="return confirm('هل انت متاكد من عملية حذف المرفق ؟')" class="btn btn-danger btn-sm" href="{{ route('procurement_officer.orders.attachment.delete_order_attachment',['id'=>$key->id]) }}"><span class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endif
                                    @if(!empty($child->attachment_copy))
                                        <tr>
                                            <td>التخليص</td>
                                            <td>
                                                {{ $child->clerance_attachemnt['type_name'] }} - نسخة
                                            </td>
                                            <td>
                                                <a type="text"
                                                   href="{{ asset('storage/attachment/'.$child->attachment_copy) }}"
                                                   download="{{ $child->attachment_copy }}" class="btn btn-primary btn-sm"><span
                                                        class="fa fa-download"></span></a>
                                                <button
                                                    onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$child->attachment_copy) }}',null)"
                                                    href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                    data-target="#modal-lg-view_attachment"><span
                                                        class="fa fa-search"></span></button>
                                            </td>
                                            <td>
                                                {{ $child->created_at }}
                                            </td>
                                            <td> {{ $child->notes }}</td>
                                            <td>
                                                <a onclick="return confirm('هل انت متاكد من عملية حذف المرفق ؟')" class="btn btn-danger btn-sm" href="{{ route('procurement_officer.orders.attachment.delete_order_attachment',['id'=>$key->id]) }}"><span class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endif

                                @endforeach
                            @endforeach
                        @endif
                        @if(!$delivery->isEmpty())
                            @foreach($delivery as $key)
                                @if(!empty($key->attachment))
                                    <tr>
                                        <td>التوصيل</td>
                                        <td>
                                            ملف مرفق توصيل شحنة
                                        </td>
                                        <td>
                                            <a type="text"
                                               href="{{ asset('storage/attachment/'.$key->attachment) }}"
                                               download="{{ $key->attachment }}" class="btn btn-primary btn-sm"><span
                                                    class="fa fa-download"></span></a>
                                            <button
                                                onclick="viewAttachment({{ $key->id }},'{{ asset('storage/attachment/'.$key->attachment) }}',null)"
                                                href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view_attachment"><span
                                                    class="fa fa-search"></span></button>
                                        </td>
                                        <td>
                                            {{ $child->created_at }}
                                        </td>
                                        <td> {{ $child->notes }}</td>
                                        <td>
                                            <a onclick="return confirm('هل انت متاكد من عملية حذف المرفق ؟')" class="btn btn-danger btn-sm" href="{{ route('procurement_officer.orders.attachment.delete_order_attachment',['id'=>$key->id]) }}"><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                        @if(($shipping->isEmpty() && $shipping_award->isEmpty() && $price_offer->isEmpty() && $anchor->isEmpty() && $letter_bank->isEmpty() && $cash_payments->isEmpty() && $insurance->isEmpty() && $clerance->isEmpty() && $delivery->isEmpty()))
                            <tr>
                                <td colspan="5"><span>لا توجد بيانات</span></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="modal fade" id="modal-lg-order_attachment">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('procurement_officer.orders.attachment.create_order_attachment') }}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $order->id }}" name="order_id">
                        <div class="modal-header">
                            <h4 class="modal-title">اضافة مرفق</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @csrf

                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">يرجى ارفاق الملف</label>
                                        <input name="attachment" type="file" class="form-control">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">اضافة ملاحظة</label>
                                        <textarea class="form-control" name="notes" id="" cols="30" rows="3"></textarea>
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

