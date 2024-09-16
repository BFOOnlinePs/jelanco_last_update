<table class="table table-sm p-0 m-0">
    <tr>
        <td>الرقم</td>
        <td>الاسم</td>
        <td>نسخة</td>
        <td>اصلية</td>
        <td>العمليات</td>
    </tr>
    @foreach($data as $child)
        <tr id="delete_row_{{ $child->id }}">
            <td>{{ $child->id }}</td>
            <td>{{ $child['attachment_type']->type_name }}</td>
            <td>
                @if(empty($child->attachment_original))
                    <form
                        id="upload-form-{{ $child->id }}"
                        name="upload-form"
                        data-id="{{ $child->id }}"
                    >
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token()}}">
                        <input type="hidden" name="order_id"
                               value="{{ $order_id }}">
                        <input type="hidden" class="id"
                               name="id"
                               value="{{ $child->id }}">
                        <input type="hidden" id="order_clearance_id_{{$child->id}}" class="order_clearance_id"
                               name="order_clearance_id"
                               value="{{ $child->order_clearance_id }}">
                        <div class="image-upload">
                            <label for="file-input-{{ $child->id }}">
                                <span class="fa fa-upload btn btn-dark"></span>
                            </label>
                            <input
                                id="file-input-{{ $child->id }}"
                                name="attachment_original" type="file"/>
                            <button type="button" class="btn btn-success btn-sm"
                                    onclick="clearance_update({{ $child->id }},{{ $child->order_clearance_id }})"><span
                                    class="fa fa-save"></span></button>
                        </div>
                    </form>
                @else
                    <a type="text"
                       href="{{ asset('storage/attachment/'.$child->attachment_original) }}"
                       download="attachment"
                       class="btn btn-primary btn-sm"><span
                            class="fa fa-download"></span></a>
                    <button
                        onclick="viewAttachment({{ $child->id }},'{{ asset('storage/attachment/'.$child->attachment_original) }}',null)"
                        href="" class="btn btn-success btn-sm"
                        data-toggle="modal"
                        data-target="#modal-lg-view_attachment"><span
                            class="fa fa-search"></span></button>
                    <button
                        onclick="update_to_null_order_clearance_attachment({{ $child->id }},'original',{{ $child->order_clearance_id }})"
                        class="btn btn-danger btn-sm"><span
                            class="fa fa-trash"></span></button>
                @endif
            </td>
            <td>
                @if(empty($child->attachment_copy))
                    <form
                        id="upload-form-copy-{{ $child->id }}"
                        name="upload-form-copy"
                        data-id="{{ $child->id }}"
                    >
                        <input type="hidden" name="_token" value="{{ csrf_token()}}">
                        <input type="hidden" name="order_id"
                               value="{{ $order_id }}">
                        <input type="hidden" class="id"
                               name="id"
                               value="{{ $child->id }}">
                        <input type="hidden" id="order_clearance_id_{{$child->id}}" class="order_clearance_id"
                               name="order_clearance_id"
                               value="{{ $child->order_clearance_id }}">
                        <div class="image-upload">
                            <label for="file-input-copy-{{ $child->id }}">
                                <span class="fa fa-upload btn btn-dark"></span>
                            </label>
                            <input
                                id="file-input-copy-{{ $child->id }}"
                                name="attachment_copy" type="file"/>
                            <button type="button" class="btn btn-success btn-sm"
                                    onclick="clearance_update_copy({{ $child->id }},{{ $child->order_clearance_id }})">
                                <span class="fa fa-save"></span></button>
                        </div>
                    </form>
                @else
                    <a type="text"
                       href="{{ asset('storage/attachment/'.$child->attachment_copy) }}"
                       download="attachment"
                       class="btn btn-primary btn-sm"><span
                            class="fa fa-download"></span></a>
                    <button
                        onclick="viewAttachment({{ $child->id }},'{{ asset('storage/attachment/'.$child->attachment_copy) }}',null)"
                        href="" class="btn btn-success btn-sm"
                        data-toggle="modal"
                        data-target="#modal-lg-view_attachment"><span
                            class="fa fa-search"></span></button>
                    <button
                        onclick="update_to_null_order_clearance_attachment({{ $child->id }},'copy',{{ $child->order_clearance_id }})"
                        class="btn btn-danger btn-sm"><span
                            class="fa fa-trash"></span></button>
                @endif
            </td>
            <td>
                <button onclick="delete_order_clearance_attachment({{ $child->id }},{{$child->order_clearance_id}})"
                        class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></button>
            </td>
        </tr>
    @endforeach
</table>
