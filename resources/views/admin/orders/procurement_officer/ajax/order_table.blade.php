<div class="col-sm-12">
    <div class="table-responsive">
        <table class="table  table-bordered table-hover dataTable dtr-inline">
            <thead>
                <tr>
                    {{--                <th>رقم طلبية الشراء</th> --}}
                    <th style="width: 10px">#</th>
                    <th style="width: 170px">الرقم المرجعي للطلبية</th>
                    <th style="min-width: 200px">الترسية</th>
                    <th style="min-width: 200px">مجال العمل</th>
                    <th style="width: 180px">متابعة بواسطة</th>
                    <th style="width: 150px">تاريخ الطلبية</th>
                    <th style="width: 200px">حالة الطلبية</th>
                    <th style="width: 100px">العمليات</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">
                            <h3 class="p-5">لا توجد نتائج</h3>
                        </td>
                    </tr>
                @else
                    @foreach ($data as $key)
                        <tr class="">
                            {{--                    <td>{{ $key->id }}</td> --}}
                            {{--                    <td>{{ $key->order_id }}</td> --}}
                            <td>
                                {{ ($data->currentpage() - 1) * $data->perpage() + $loop->index + 1 }}
                            </td>
                            <td>{{ $key->reference_number }}
                                @if (auth()->user()->user_role != 3 && auth()->user()->user_role != 9 && auth()->user()->user_role != 11)
                                    <span onclick="getReferenceNumber({{ $key->id }})"
                                        class="fa fa-edit text-success" style="float: left" data-toggle="modal"
                                        data-target="#modal-reference_number"></span>
                                @endif
                            </td>
                            <td>
                                @if ($view == 'officer_view' || (auth()->user()->user_role == 9 || auth()->user()->user_role == 11))
                                    @foreach ($key->supplier as $child)
                                        <span>{{ $child['name']->name }},</span>
                                    @endforeach
                                @else
                                    @foreach ($key->supplier as $child)
                                        <a
                                            href="{{ route('users.supplier.details', ['id' => $child['name']->id]) }}">{{ $child['name']->name }},</a>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @foreach ($key->supplier as $child)
                                    @if (!empty($child->user_categories))
                                        {{ implode(', ', $child->user_categories) }}
                                    @else
                                        empty
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @if (
                                    $view == 'officer_view' ||
                                        auth()->user()->user_role == 9 ||
                                        auth()->user()->user_role == 11 ||
                                        auth()->user()->user_role == 2)
                                    <select disabled onchange="updateToUser({{ $key->id }} , this.value)"
                                        class="" name="" id="">
                                        @foreach ($users as $user)
                                            <option @if ($user->id == ($key['to_user']->id ?? 1)) selected @endif
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select onchange="updateToUser({{ $key->id }} , this.value)" class=""
                                        name="" id="">
                                        @foreach ($users as $user)
                                            <option @if ($user->id == ($key['to_user']->id ?? 1)) selected @endif
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <div class="mt-1">
                                    @php
                                        $total_count = \App\Models\OrderComment::where('order_id', $key->id)->count();
                                        $unseen_count = \App\Models\OrderComment::where('order_id', $key->id)
                                                                                  ->where('user_id', '!=', auth()->id())
                                                                                  ->where('is_seen', 0)
                                                                                  ->count();

                                        if ($unseen_count > 0) {
                                            $btn_class = 'btn-danger'; // رسائل جديدة لم تُقرأ
                                            $icon_class = 'fas fa-bell';
                                        } elseif ($total_count > 0) {
                                            $btn_class = 'btn-info text-white'; // يوجد رسائل لكن مقروءة
                                            $icon_class = 'fas fa-envelope-open-text';
                                        } else {
                                            $btn_class = 'btn-outline-secondary'; // لا توجد رسائل اطلاقاً
                                            $icon_class = 'far fa-comment-dots';
                                        }
                                    @endphp
                                    <button type="button" 
                                            class="btn btn-sm {{ $btn_class }} rounded-pill shadow-sm mt-2 px-3" 
                                            onclick="openStorekeeperNotesModal({{ $key->id }})"
                                            title="ملاحظات المستودع"
                                            style="font-size: 12px; font-weight: bold; transition: all 0.2s;">
                                        <i class="{{ $icon_class }} ml-1"></i> ملاحظات المستودع
                                        @if($unseen_count > 0)
                                            <span class="badge badge-light badge-pill text-danger shadow-sm mr-1">{{ $unseen_count }}</span>
                                        @endif
                                    </button>
                                </div>
                            </td>
                            <td>
                                {{ $key->inserted_at }}
                                @if (auth()->user()->user_role != 9 && auth()->user()->user_role != 11)
                                    <span onclick="showDueDate({{ $key->id }})" class="fa fa-edit text-success"
                                        style="float: left" data-toggle="modal"
                                        data-target="#modal-show_due_date"></span>
                                @endif
                                @if (!empty($key->expected_arrival_date))
                                    <span class="badge bg-success pt-1" style="font-size: 10px;display: block">وصول
                                        متوقع : <span>{{ $key->expected_arrival_date }}</span></span>
                                @endif
                            </td>
                            <td>
                                {{-- كود الـ Select (كما هو بدون تغيير) --}}
                                @if (auth()->user()->user_role != 9 && auth()->user()->user_role != 11)
                                    <select
                                        style="background-color: {{ $key['order_status_color']->status_color ?? 'white' }};color: {{ $key['order_status_color']->status_text_color ?? 'black' }};"
                                        onchange="updateOrderStatus({{ $key->id }} , this.value); toggleDateButton({{ $key->id }}, this.value);"
                                        id="order_status_{{ $key->id }}">
                                        @foreach ($order_status as $status)
                                            <option @if ($status->id == $key->order_status) selected @endif
                                                value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select disabled
                                        style="background-color: {{ $key['order_status_color']->status_color ?? 'white' }};color: {{ $key['order_status_color']->status_text_color ?? 'black' }};"
                                        id="order_status_{{ $key->id }}">
                                        @foreach ($order_status as $status)
                                            <option @if ($status->id == $key->order_status) selected @endif
                                                value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                @endif

                                {{-- ================================================= --}}
                                {{-- منطقة التاريخ (التي سيتم تحديثها بـ AJAX) --}}
                                {{-- ================================================= --}}
                                <div id="date_container_{{ $key->id }}"
                                    style="margin-top: 5px; text-align: center; display: {{ $key->order_status == 5 ? 'block' : 'none' }};">

                                    @if (!empty($key->order_in_production_upon_arrival))
                                        {{-- حالة وجود تاريخ --}}
                                        <span class="badge badge-warning text-dark" style="font-size: 11px;">
                                            {{ $key->order_in_production_upon_arrival }}
                                        </span>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#AddNewDate"
                                            onclick="setOrderIdForDate({{ $key->id }})" title="تعديل التاريخ"
                                            class="text-dark ml-1">
                                            <i class="fa fa-edit" style="font-size: 10px;"></i>
                                        </a>
                                    @else
                                        {{-- حالة عدم وجود تاريخ --}}
                                        <div id="btn_add_date_{{ $key->id }}">
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#AddNewDate"
                                                onclick="setOrderIdForDate({{ $key->id }})"
                                                title="إضافة تاريخ جديد">
                                                <i class="fa fa-plus-circle text-primary" style="font-size: 18px;"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a target="_blank" data-toggle="tooltip" data-placement="top" title="التفاصيل"
                                    @if (auth()->user()->user_role == 9) href="{{ route('orders.order_items.index', ['order_id' => $key->id]) }}" @elseif(auth()->user()->user_role == 11)  href="{{ route('procurement_officer.orders.shipping.index', ['order_id' => $key->id]) }}" @else href="{{ route('procurement_officer.orders.product.index', ['order_id' => $key->id]) }}" @endif
                                    class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>


                                {{--                        <button type="button" onclick="getReferenceNumber({{ $key->order_id }})" class="btn btn-success btn-sm" data-toggle="modals" data-target="#modals-reference_number"> --}}
                                {{--                            تعديل الرقم المرجعي --}}
                                {{--                        </button> --}}
                                @if (auth()->user()->user_role != 3 && auth()->user()->user_role != 9 && auth()->user()->user_role != 11)
                                    <a data-toggle="tooltip" data-placement="top" title="حذف"
                                        href="{{ route('orders.procurement_officer.delete_order', ['id' => $key->id]) }}"
                                        onclick="return confirm('هل انت متاكد من عملية الحذف علما انه بعد الحذف سوف يتم نقله لسلة المحذوفات')"
                                        class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div>
        {{ $data->links() }}
    </div>
</div>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

    function toggleDateButton(order_id, status_val) {
        if (status_val == 5) {
            $('#date_container_' + order_id).show();
        } else {
            $('#date_container_' + order_id).hide();
        }
    }
</script>
