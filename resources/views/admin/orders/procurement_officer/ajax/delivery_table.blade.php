<table class="table table-sm table-hover">
    @foreach($data as $key)
        <tr id="order_item_delivery_row_{{ $key->id }}">
            <td>{{ $key['estimation_cost_element']->name }}</td>
            <td>                        <input class="form-control"
                                               value="@if(empty($key->estimation_cost_price)) {{ \App\Models\DeliveryEstimationCostModel::where('element_cost_id',$key['estimation_cost_element']->id)->value('estimation_price') }} @else {{ $key->estimation_cost_price }} @endif"
                                               type="text"
                                               placeholder="السعر"
                                               onchange="update_order_local_delivery_items({{ $key->id }},this.value)">
            </td>
            <td>
                <button onclick="delete_order_local_delivery_items({{ $key->id }})" class="btn btn-danger btn-sm"><span
                        class="fa fa-trash"></span></button>
            </td>
        </tr>
{{--        <div class="card">--}}
{{--            <div class="card-header">--}}
{{--                <span>{{ $key['estimation_cost_element']->name }}</span>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-12">--}}
{{--                        <label for="">السعر</label>--}}
{{--                        <input class="form-control"--}}
{{--                               value="{{ $key->estimation_cost_price }}" type="text"--}}
{{--                               placeholder="السعر">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    @endforeach
</table>
