<div class="col-sm-12">
    <div class="table-responsive">
        <table id="example1" class="table table-bordered table-hover  dataTable dtr-inline"
               aria-describedby="example1_info">
            <thead>
            <tr>
                {{--                <th>رقم طلبية الشراء</th>--}}
                <th>الرقم المرجعي للطلبية</th>
                <th>الترسية</th>
                <th>بواسطة</th>
                <th>تاريخ الارسال</th>
                <th>حالة الطلبية</th>
                <th>العمليات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key)
                <tr class="">
                    {{--                    <td>{{ $key->id }}</td>--}}
                    {{--                    <td>{{ $key->order_id }}</td>--}}
                    <td>{{ $key->reference_number }}
                        @if(!auth()->user()->user_role == 3)
                            <span onclick="getReferenceNumber({{ $key->order_id }})" class="fa fa-edit text-success" style="float: left" data-toggle="modal" data-target="#modal-reference_number"></span></td>
                    @endif
                    <td>
                        @foreach($key->supplier as $child)
                            {{ $child['name']->name }},
                        @endforeach
                    </td>
                    <td>{{ $key['user']->name }}</td>
                    <td>{{ $key->created_at }}</td>
                    <td>
                        <span>تم ارسالها الى المشتريات</span>
                    </td>
                    <td>
                        <a href="{{ route('procurement_officer.orders.product.index',['order_id'=>$key->order_id]) }}"
                           class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>
                        {{--                        <button type="button" onclick="getReferenceNumber({{ $key->order_id }})" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reference_number">--}}
                        {{--                            تعديل الرقم المرجعي--}}
                        {{--                        </button>--}}
                        @if(auth()->user()->user_role != 3)

                            <a href="{{ route('orders.procurement_officer.delete_order',['id'=>$key->order_id]) }}" onclick="return confirm('هل انت متاكد من عملية الحذف علما انه بعد الحذف سوف يتم نقله لسلة المحذوفات')" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                        @endif
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

