<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ملخص الفاتورة</title>
    <style>
        @page{
            background-image: url("{{ asset('img/background/jelanco-background.jpg') }}");
            background-image-resize:6;
            margin-top:220px;
            margin-bottom:50px;
        }

        @page :first{
            background-image: url("{{ asset('img/background/jelanco-background.jpg') }}");
            background-image-resize:6;
            margin-bottom:50px;
            margin-top:220px;
        }
        .title{

        }
        table, td, th {
            border: 1px solid black;
        }
        .table{
            padding-top: 150px;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }
        th{
            height: 70%;
        }
    </style>
</head>
<body>
<h2 style="text-align: center">الترسية</h2>
    @foreach($anchor as $key)
        <div class="col-md-12 col-sm-6 col-12">
            <div class="info-box bg-success">
                <div class="info-box-content">
                    <div class="row">
                        <div class="col-md-11">
                            <span class="info-box-text">{{ $key['supplier']->name }}</span>
                            <br>
                        </div>
                        <div class="table-responsive mt-2">
                            <table cellpadding="3" class="table bg-white table-bordered table-hover table-sm text-center">
                                <thead>
                                <tr>
                                    <th>الرقم</th>
                                    <th>الصورة</th>
                                    <th>اسم الصنف</th>
                                    <th>الكمية</th>
                                    <th>الوحدة</th>
                                    <th>السعر</th>
                                    <th>الاجمالي</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sum = 0;
                                @endphp
                                @foreach($order_items as $order_item)
                                    @php
                                        $sum += (double)$order_item->qty * (double) \App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('price')
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            @if(empty($order_item['product']->product_photo))
                                                <img width="100" src="{{ asset('img/no_img.jpeg') }}" alt="">
                                            @else
                                                <img width="100"
                                                     src="{{ asset('storage/product/'.$order_item['product']->product_photo) }}"
                                                     alt="">
                                            @endif
                                        </td>
                                        <td>{{ $order_item['product']->product_name_ar }}</td>
                                        <td>{{ $order_item->qty }}</td>
                                        <td>{{ $order_item['unit']->unit_name }}</td>
                                        <td>
                                                        <span>
                                                            {{ (double)\App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('price') }}
                                                        </span>
                                        </td>
                                        <td>
                                            {{ (double)$order_item->qty * (double) \App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('price') }}
                                            <br>{{ $key['currency']->currency_name }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" class="text-center bg-dark">المجموع</td>
                                    <td class="text-center bg-warning" dir="ltr">{{ $sum }} {{ $key['currency']->currency_name }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4>الملاحظات :</h4>
        <span class="progress-description">

{{ $key->notes }}
        </span>

        <hr>
    @endforeach
<h2 style="text-align: center">الملف المالي</h2>
<table cellpadding="5" class="table table-sm table-hover table-bordered text-center">
    <thead class="bg-dark">
    <tr>
        <th>المبلغ</th>
        <th>النسبة</th>
        <th>تاريخ الاستحقاق</th>
        <th>نوع الدفعة</th>
        <th>حالة الطلبية</th>
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
            <td class="text-center" colspan="4">لا توجد بيانات</td>
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
            <td>
                <select onchange="updatePaymentStatus({{ $key->id }},this.value,{{ $loop->index }})" style="height: 30px;width: 150px" class="@if($key->payment_status == 0) bg-danger @elseif($key->payment_status == 1) bg-success @endif" name="payment_status" id="payment_status_{{$loop->index}}">
                    <option @if($key->payment_status == 0) selected @endif value="0">بانتظار الدفع</option>
                    <option @if($key->payment_status == 1) selected @endif value="1">مدفوعة</option>
                </select>
            </td>
            <td>
                @if(empty($key->attachment))
                    لا يوجد ملف
                @else
                    <a type="text"
                       href="{{ asset('storage/attachment/'.$key->attachment) }}"
                       download="attachment" class="btn btn-primary btn-sm"><span class="fa fa-download"></span></a>
                    <button onclick="viewAttachment('{{ asset('storage/attachment/'.$key->attachment) }}')" href="" class="btn btn-success btn-sm" data-toggle="modal"
                            data-target="#modal-lg-view_attachment"><span
                            class="fa fa-search"></span></button>
                @endif
            </td>
            <td>
                <a href="{{ route('procurement_officer.orders.financial_file.edit_cash_payment',['id'=>$key->id]) }}" class="btn btn-sm btn-success"><i class="fa fa-edit mt-1"></i></a>
                <a href="{{ route('procurement_officer.orders.financial_file.delete_cash_payment',['id'=>$key->id]) }}" onclick="return confirm('لا يمكن استرجاع الباينات هل انت متاكد من حذفها ؟')" class="btn btn-sm btn-danger"><i class="fa fa-trash mt-1"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<table class="table-bordered table-hover" width="100%">
    <thead class="bg-dark">
    <tr>
        <th>نوع الاعتماد</th>
        <th>قيمة الاعتماد</th>
        <th>اسم البنك</th>
        <th>تاريخ الاستحقاق</th>
        {{--                            <th>المدة باليوم</th>--}}
        {{--                            <th>ملاحظات</th>--}}
        {{--                            <th>مرفقات</th>--}}
        <th>الحالة</th>
        <th>العمليات</th>
    </tr>
    </thead>
    <tbody class="">
    @if($letter_bank->isEmpty())
        <tr>
            <td class="text-center" colspan="6">لا توجد بيانات</td>
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
            <td>{{ $key['bank_name']->user_bank_name }}</td>
            <td>{{ $key->due_date }}</td>
            <td>{{ $key->status }}</td>
            <td>
                <a href="{{ route('procurement_officer.orders.financial_file.edit_letter_bank',['id'=>$key->id]) }}" class="btn btn-sm btn-success"><i class="fa fa-edit mt-1"></i></a>
                <a href="{{ route('procurement_officer.orders.financial_file.delete_letter_bank',['id'=>$key->id]) }}" onclick="return confirm('لا يمكن استرجاع الباينات هل انت متاكد من حذفها ؟')" class="btn btn-sm btn-danger"><i class="fa fa-trash mt-1"></i></a>
                <button onclick="getLetterBankId({{ $key->id }})" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#modal-extension_modification">تمديد اعتماد</button>
            </td>
        </tr>
    @if(!$key->modifications->isEmpty())
        <thead class="">
        <tr class=" bg-dark">
            <th colspan="1" class="bg-white"></th>
            <th>تاريخ الاستحقاق</th>
            <th>ملاحظات</th>
            <th>الملف</th>
            <th>اضافة بواسطة</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @if($letter_bank->isEmpty())
            <tr>
                <td colspan="6"></td>
            </tr>
        @endif
        @foreach($key->modifications as $child)
            <tr class="">
                <td colspan="1"></td>
                <td>{{ $child->new_due_date }}</td>
                <td>{{ $child->notes }}</td>
                <td>
                    @if(empty($child->attachment))
                        لا يوجد ملف
                    @else
                        <a href="{{ asset('storage/attachment/'.$child->attachment) }}" download="attachment" class="btn btn-primary btn-sm">تحميل</a>
                    @endif
                </td>
                <td>{{ \App\Models\User::where('id',$child->insert_by)->value('name') }}</td>
                <td>
                    <a href="{{ route('procurement_officer.orders.financial_file.edit_extension',['id'=>$child->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit mt-1"></span></a>
                    <a href="{{ route('procurement_officer.orders.financial_file.delete_extension',['id'=>$child->id]) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash mt-1"></span></a>
                </td>
            </tr>
        @endforeach
        @endif
        <tr>
            <td colspan="6">
                <hr></td>
        </tr>
        </tbody>

        @endforeach
        </tbody>
</table>

</body>
</html>
