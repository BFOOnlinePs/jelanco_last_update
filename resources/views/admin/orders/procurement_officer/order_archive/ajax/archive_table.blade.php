<div class="col-sm-12">
    <div class="table-responsive">
        <table id="example1" class="table table-bordered table-hover dataTable dtr-inline"
               aria-describedby="example1_info">
            <thead>
            <tr>
                {{--                <th>رقم طلبية الشراء</th>--}}
                <th>الرقم المرجعي للطلبية</th>
                <th>الترسية</th>
                <th>متابعة بواسطة</th>
                <th>تاريخ الطلبية</th>
                <th>حالة الطلبية</th>
                <th>العمليات</th>
            </tr>
            </thead>
            <tbody>
            @if($data->isEmpty())
                <tr>
                    <td colspan="6" class="text-center"><h3 class="p-5">لا توجد نتائج</h3></td>
                </tr>
            @else
                @foreach($data as $key)
                    <tr class="">
                        {{--                    <td>{{ $key->id }}</td>--}}
                        {{--                    <td>{{ $key->order_id }}</td>--}}
                        <td>{{ $key->reference_number }}
                            @if(auth()->user()->user_role != 3)
                                <span onclick="getReferenceNumber({{ $key->id }})" class="fa fa-edit text-success"
                                      style="float: left" data-toggle="modal"
                                      data-target="#modal-reference_number"></span></td>
                        @endif
                        <td>
                            @foreach($key->supplier as $child)
                                {{ $child['name']->name }},
                            @endforeach
                        </td>
                        <td>
                            @if($view == 'officer_view')
                                <select disabled onchange="updateToUser({{ $key->id }} , this.value)" class="form-control" name="" id="">
                                    @foreach($users as $user)
                                        <option @if($user->id == ($key['to_user']->id ?? 1)) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <select onchange="updateToUser({{ $key->id }} , this.value)" class="form-control" name="" id="">
                                    @foreach($users as $user)
                                        <option @if($user->id == ($key['to_user']->id ?? 1)) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                        <td>
                            {{ $key->inserted_at }}
                            <span onclick="showDueDate({{ $key->id }})" class="fa fa-edit text-success"
                                  style="float: left" data-toggle="modal" data-target="#modal-show_due_date"></span>
                        </td>
                        <td>
                            <select
                                style="background-color: {{ $key['order_status_color']->status_color ?? 'white' }};color: {{ $key['order_status_color']->status_text_color ?? 'black' }};"
                                onchange="updateOrderStatus({{ $key->id }} , this.value)" class="form-control" name=""
                                id="order_status_{{$key->id}}">
                                @foreach($order_status as $status)
                                    <option @if($status->id == $key->order_status) selected
                                            @endif value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <a data-toggle="tooltip" data-placement="top" title="التفاصيل"
                               href="{{ route('procurement_officer.orders.product.index',['order_id'=>$key->id]) }}"
                               class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>
                            {{--                        <button type="button" onclick="getReferenceNumber({{ $key->order_id }})" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reference_number">--}}
                            {{--                            تعديل الرقم المرجعي--}}
                            {{--                        </button>--}}
                            @if(auth()->user()->user_role != 3)

                                <a data-toggle="tooltip" data-placement="top" title="حذف"
                                   href="{{ route('orders.procurement_officer.delete_order',['id'=>$key->id]) }}"
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
</div>
