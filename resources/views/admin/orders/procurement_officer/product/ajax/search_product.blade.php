    <table style="width: 100%" class="table-sm table-bordered table-hover">
        <thead>
            <tr>
                <th></th>
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
                               onchange="create_product_ajax({{ $key->id }})"
                               name="checkbox[]"
                               value="{{ $key->id }}">
                    </td>
                    <td>
                        @if (!empty($key->product_photo))
                        <img style="width: 30px" src="{{ asset('storage/product/'.$key->product_photo) }}" alt="">
                        @else
                        <img style="width: 30px" src="{{ asset('img/no_img.jpeg') }}" alt="">
                        @endif
                        {{ $key->barcode }} <span class=" alert-warning">|</span> {{ $key->product_name_ar }} <span class=" alert-warning">|</span> {{ $key->product_name_en }}
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
