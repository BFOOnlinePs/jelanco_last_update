<table class="table table-hover table-bordered table-sm">
    <tbody>
    @if($data->isEmpty())
        <tr>
            <td class="text-center">لا توجد نتائج</td>
        </tr>
    @else
        @foreach($data as $key)
            <tr>
                <td>
                    <a href="{{ route('procurement_officer.orders.product.index',['order_id'=>$key->id]) }}" target="_blank">{{ $key->reference_number }}</a>
                </td>
                <td>
                    <button onclick="create_tag_for_message({{ $key }})" class="btn btn-success btn-sm">عمل اشارة</button>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
