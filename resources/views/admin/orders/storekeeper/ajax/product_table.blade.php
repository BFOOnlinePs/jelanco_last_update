<table style="width: 100%" class="table-sm table-bordered table-hover">
    <thead>
    <tr>
        <th></th>
        <th>باركود الصنف</th>
        <th>اسم الصنف</th>
    </tr>
    </thead>
    <tbody>
    @if (!$data->isEmpty())
        @foreach ($data as $key)
            <input type="hidden" value="{{ $key->unit_id }}" id="unit_id_{{ $key->id }}">
            <tr>
                <td>
                    <input type="checkbox"
                           onchange="create_order_items_ajax({{ $key->id }},{{ $key->unit_id }})"
                           name="checkbox[]"
                           value="{{ $key->id }}">
                </td>
                <td>{{ $key->barcode }}</td>
                <td>
                    @if (!empty($key->product_photo))
                        <img style="width: 30px" src="{{ asset('storage/product/'.$key->product_photo) }}" alt="">
                    @else
                        <img style="width: 30px" src="{{ asset('img/no_img.jpeg') }}" alt="">
                    @endif
                    {{ $key->product_name_ar }}
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="2" class="text-center">لا يوجد نتائج</td>
        </tr>
    @endif

    </tbody>
</table>
{{ $data->links() }}
