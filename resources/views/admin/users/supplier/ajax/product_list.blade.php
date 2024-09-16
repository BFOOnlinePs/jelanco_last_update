<table class="table table-hover table-bordered table-sm" aria-describedby="example1_info">
    <thead>
        <tr>
            <th>المنتج</th>
            <th>الصنف باللغة الانجليزية</th>
            <th>
                العمليات
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($product_supplier as $key)
            <tr>
                <td>{{ $key['product']->product_name_ar ?? '' }}</td>
                <td>
                    <input style="direction:ltr !important;" onchange="edit_product_ajax({{ $key['product']->id }})"
                        id="product_name_en_{{ $key['product']->id }}" class="form-control" type="text"
                        value="{{ $key['product']->product_name_en }}">
                </td>
                <td>
                    <a href="{{ route('users.supplier.delete_product_supplier', ['id' => $key->id]) }}"
                        onclick="return confirm('هل انت متاكد من عملية الحذف ؟')" class="btn btn-danger btn-sm"><span
                            class="fa fa-trash"></span></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
