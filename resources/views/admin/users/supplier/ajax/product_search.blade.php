<table id="example1" class="table table-hover table-bordered table-sm">
    <thead>
        <tr>
            <th></th>
            <th>الصنف</th>
        </tr>
    </thead>
    <tbody>
        @if ($data->isEmpty())
            <tr>
                <td colspan="2"><p class="text-center">لا توجد نتائج لبحثك</p></td>
            </tr>
            @else
            @foreach ($data as $key)
            <tr>
                <td>
                    <input onchange="add_to_product_supplier_ajax({{ $key->id }})" id="checkbox_product_{{ $key->id }}" @if(!empty(App\Models\ProductSupplierModel::where('user_id',$user->id)->where('product_id',$key->id)->first())) checked @endif type="checkbox">
                </td>
                <td>{{ $key->product_name_ar }}</td>
            </tr>
        @endforeach
        @endif
    </tbody>
</table>
    {{ $data->links() }}
