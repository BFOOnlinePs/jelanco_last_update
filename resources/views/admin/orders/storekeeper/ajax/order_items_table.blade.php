<table class="table table-hover border">
    <thead>
    <tr>
        <th>الرقم</th>
        <th>اسم الصنف</th>
        <th>الكمية</th>
        <th>الوحدة</th>
        @if($order->order_status == 0)
            <th>العمليات</th>
        @endif
    </tr>
    </thead>
    <tbody>
    @if($data->isEmpty())
        <tr>
            <td colspan="5" class="text-center"> لا توجد بيانات</td>
        </tr>
    @else
        @foreach($data as $key)
            <tr id="delete_tr_{{ $loop->index }}">
                <td>{{ $key->id }}</td>
                <td>{{ $key['product']->product_name_ar }}</td>
                <td>
                    <input @if($order->order_status == 1) readonly
                           @endif onchange="updateQty( this.value  , {{ $key->id }})"
                           id="qty_{{ $loop->index }}" style="width: 80%" class="form-control"
                           type="number" value="{{ $key->qty }}" placeholder="ادخل الكمية">
                </td>
                <td>
                    <select @if($order->order_status == 1) disabled
                            @endif onchange="updateUnit(this.value  , {{ $key->id }})"
                            name="product_id"
                            class="form-control select2bs4"
                            style="width: 80%;" data-select2-id="{{ $loop->index }}"
                            >
                        @foreach($unit as $unit_key)
                            <option @if(old('unit_id',$key->unit_id) == $unit_key->id) selected
                                    @endif value="{{ $unit_key->id }}">{{ $unit_key->unit_name }}</option>
                        @endforeach
                    </select>
                </td>
                @if($order->order_status == 0)

                    <td>
                        <button class="btn btn-danger btn-sm"
                                onclick="deleteItems({{ $key->id }} , {{ $loop->index }})">ازالة X
                        </button>
                    </td>
                @endif
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
