    <div class="text-center">
        <span style="font-size: 20px;font-weight: bold">{{ $user_reciver->name }}</span>
        <button type="button" id="refresh_message" style="float: left" class="btn btn-dark btn-sm"><span class="fa fa-refresh"></span></button>
    </div>
    <div class="border p-3 mt-3" >
        @if(!$data->isEmpty())
            @foreach($data as $key)
                @if($key->sender == \Illuminate\Support\Facades\Auth::user()->id)
                    <div class="row mt-2">
                        <div class="col-md-12">
                            @if(empty($key->order_tag))
                                <span onclick="open_modal_for_order_tag({{ $key }})" class="fa fa-tag p-2 text-warning" style="float: right"></span>
                            @else
                                <span onclick="delete_message_tag({{ $key->id }})" class="fa fa-tag p-2 text-success" style="float: right"></span>
                            @endif
                            <span class="border p-2" style="float:right">{{ $key->message }}</span>
                            <span class="mt-2 p-2" style="font-size:10px">{{ $key->insert_at }}</span>
                        </div>
                    </div>
                @else
                    <div class="row mt-2">
                        <div class="col-md-12">
                            @if(empty($key->order_tag))
                                <span onclick="open_modal_for_order_tag({{ $key }})" class="fa fa-tag p-2 text-warning" style="float: left"></span>
                            @else
                                <span onclick="delete_message_tag({{ $key->id }})" class="fa fa-tag p-2 text-success" style="float: left"></span>
                            @endif
                            <span class="border p-2" style="float:left">{{ $key->message }}</span>
                            &nbsp;
                            &nbsp;
                            <span class="mt-2 p-2" style="font-size:10px;float: left">{{ $key->insert_at }}</span>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <div class="text-center border p-3">ليس هناك رسائل</div>
        @endif
    </div>

<script>


    $('#refresh_message').on('click',function () {
        list_message_ajax($('#received_id').val());
    })
</script>
