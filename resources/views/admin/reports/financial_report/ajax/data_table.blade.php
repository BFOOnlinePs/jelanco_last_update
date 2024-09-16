<div class="card">
    <div class="card-body">
        <h4 class="">الدفعات النقدية</h4>
        @if($cash_payment && !$cash_payment->isEmpty())
            <table class="table table-sm table-hover table-bordered" cellpadding="10">
                <tr class="bg-info">
                    <th></th>
                    <th>مرجعي</th>
                    <th>اسم المورد</th>
                    <th>بواسطة</th>
                    <th>حالة الدفعة</th>
                    <th>تاريخ الاضافة</th>
                    <th>
                        <div style="display: inline;float: right">
                            تاريخ الاستحقاق
                        </div>
                        <div style="display: inline;float: left">
                            <span style="font-size: 9px;float: left;clear: both" onclick="data_table_ajax('','','due_date','asc')" class="fa fa-chevron-up"></span>
                            <span style="font-size: 9px;float: left;clear: both" onclick="data_table_ajax('','','due_date','desc')" class="fa fa-chevron-down mt-1"></span>
                        </div>
                    </th>
                    <th>تاريخ الدفع</th>
                    <th>نوع الدفعة</th>
                    <th>مبلغ الدفعة</th>
                </tr>

                @foreach($cash_payment as $key)
                    <tr>
                        <td>
                            @if(!empty($key->attachment))
                                {{--                        <a type="text"--}}
                                {{--                           href="{{ asset('storage/attachment/'.$key->attachment) }}"--}}
                                {{--                           download="attachment" class="btn btn-primary btn-sm"><span--}}
                                {{--                                class="fa fa-download"></span></a>--}}
                                <a
                                    onclick="viewAttachment('{{ asset('storage/attachment/'.$key->attachment) }}')"
                                    href="" class="text-dark" data-toggle="modal"
                                    data-target="#modal-lg-view_attachment"><span
                                        class="fa fa-eye"></span></a>
                            @endif
                        </td>
                        <td>
                            <a target="_blank" href="{{ route('procurement_officer.orders.product.index',['order_id'=>$key->order_id]) }}">{{ \App\Models\OrderModel::where('id',$key->order_id)->value('reference_number') }}</a>
                        </td>
                        <td>
                            <a href="{{ route('users.supplier.details',['id'=> App\Models\User::where('id',$request->supplier_id)->value('id') ?? \App\Models\User::where('id',\App\Models\PriceOffersModel::where('order_id',$key->order_id)->value('supplier_id'))->value('id')]) }}">{{ App\Models\User::where('id',$request->supplier_id)->value('name') ?? \App\Models\User::where('id',\App\Models\PriceOffersModel::where('order_id',$key->order_id)->value('supplier_id'))->value('name') }}</a>
                        </td>
                        <td>
                            {{ $key->inserrt_by->name }}
                        </td>
                        <td @if($key->payment_status == 1) class="bg-success" @endif>
                            @if($key->payment_status == 0)
                                بانتظار الدفع
                            @elseif($key->payment_status == 1)
                                مدفوعة
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($key->insert_at)->toDateString() }}</td>
                        <td>{{ $key->due_date }}</td>
                        <td>{{ $key->payment_date }}</td>
                        <td>
                            @if($key->payment_type == 1)
                                نقدية
                            @elseif($key->payment_type == 2)
                                مؤجلة
                            @endif
                        </td>
                        <td>
                            {{ $key->amount }}
                            &nbsp;
                            <span style="float: left" class="text-danger">({{ $key->currency->currency_name ?? '' }})</span>
                        </td>
                    </tr>
                @endforeach
                <tr class="bg-dark">
                    <td colspan="9"></td>
                    <td>
                        @foreach($cash_payment_currency as $key)
                            @if($key->sum != 0)
                                <div>
                                    <span colspan="8" class="text-center">{{ $key->currency_name }}</span>
                                    <span>{{ $key->sum ?? '' }}</span>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>

                {{--                <tr class="bg-dark">--}}
                {{--                    <td colspan="8" class="text-center">المجموع</td>--}}
                {{--                    <td>{{ $cash_payment_sum }}</td>--}}
                {{--                </tr>--}}
            </table>
            {{--            <div class="pagination pagination-cash-payment">--}}
            {{--                {{ $cash_payment->links() }}--}}
            {{--            </div>--}}
        @endif

    </div>
</div>
<div class="card">
    <div class="card-body">
        <h4 class="mt-2">الاعتمادات البنكية</h4>
        @if($letter_bank && !$letter_bank->isEmpty())
            <table class="table table-sm table-hover table-bordered" cellpadding="10">
                <tr class="bg-info">
                    <th></th>
                    <th>مرجعي</th>
                    <th>اسم المورد</th>
                    <th>بواسطة</th>
                    <th>البنك</th>
                    <th>نوع الاعتماد</th>
                    <th>حالة الاعتماد</th>
                    <th>
                        <div style="display: inline;float: right">
                            تاريخ الاستحقاق
                        </div>
                        <div style="display: inline;float: left">
                            <span style="font-size: 9px;float: left;clear: both" onclick="data_table_ajax('','','due_date','asc')" class="fa fa-chevron-up"></span>
                            <span style="font-size: 9px;float: left;clear: both" onclick="data_table_ajax('','','due_date','desc')" class="fa fa-chevron-down mt-1"></span>
                        </div>
                    </th>
                    <th>ملاحظات</th>
                    <th>السعر</th>
                </tr>

                @foreach($letter_bank as $key)
                    <tr>
                        <td>
                            @if(!empty($key->attachment))
                                {{--                        <a type="text"--}}
                                {{--                           href="{{ asset('storage/attachment/'.$key->attachment) }}"--}}
                                {{--                           download="attachment" class="btn btn-primary btn-sm"><span--}}
                                {{--                                class="fa fa-download"></span></a>--}}
                                <a
                                    onclick="viewAttachment('{{ asset('storage/attachment/'.$key->attachment) }}')"
                                    href="" class="text-dark" data-toggle="modal"
                                    data-target="#modal-lg-view_attachment"><span
                                        class="fa fa-eye"></span></a>
                            @endif
                        </td>
                        <td>
                            <a target="_blank" href="{{ route('procurement_officer.orders.product.index',['order_id'=>$key->order_id]) }}">{{ \App\Models\OrderModel::where('id',$key->order_id)->value('reference_number') }}</a>
                        </td>
                        <td>
                            <a href="{{ route('users.supplier.details',['id'=> App\Models\User::where('id',$request->supplier_id)->value('id') ?? \App\Models\User::where('id',\App\Models\PriceOffersModel::where('order_id',$key->order_id)->value('supplier_id'))->value('id')]) }}">{{ App\Models\User::where('id',$request->supplier_id)->value('name') ?? \App\Models\User::where('id',\App\Models\PriceOffersModel::where('order_id',$key->order_id)->value('supplier_id'))->value('name') }}</a>
                        </td>
                        <td>{{ $key->insert_by->name }}</td>
                        <td>{{ $key->bank->user_bank_name }}</td>
                        <td>
                            @if($key->letter_type == 1)
                                اعتماد دفع
                            @elseif($key->letter_type == 2)
                                اعتماد حين الطلب
                            @endif
                        </td>
                        <td class="@if($key->status == 1) bg-success @endif">
                            @if($key->status == 1)
                                مدفوع
                            @else
                                غير مدفوع
                            @endif
                        </td>
                        <td>{{ $key->due_date }}</td>
                        <td>{{ $key->notes }}</td>
                        <td>
                            {{ $key->letter_value }}
                            &nbsp;
                            <span style="float: left" class="text-danger">({{ $key->currency->currency_name ?? '' }})</span>
                        </td>
                    </tr>
                @endforeach
                <tr class="bg-dark">
                    <td colspan="9"></td>
                    <td>
                        @foreach($letter_bank_currency as $key)
                            @if($key->sum != 0)
                                <div>
                                    <span colspan="7" class="text-center">{{ $key->currency_name }}</span>
                                    <span>{{ $key->sum ?? '' }}</span>
                                </div>
                            @endif
                        @endforeach
                    </td>
                </tr>

                {{--                <tr class="bg-dark">--}}
                {{--                    <td colspan="7" class="text-center">المجموع</td>--}}
                {{--                    <td>{{ $letter_bank_sum }}</td>--}}
                {{--                </tr>--}}
            </table>
            {{--            <div class="pagination pagination-letter-bank">--}}
            {{--                {{ $letter_bank->links() }}--}}
            {{--            </div>--}}
        @endif

    </div>
</div>

