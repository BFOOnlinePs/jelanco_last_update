{{--@foreach($data as $key)--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="notebook-paper">--}}
{{--            <select style="position: absolute;top: 50px ; z-index: 1 ; " onchange="updateStatus({{ $key->id }},this.value)" style="width: 120px" name="" id="">--}}
{{--                <option @if($key->status == 'new') selected @endif value="new">جديدة</option>--}}
{{--                <option @if($key->status == 'in_progress') selected @endif value="in_progress">قيد المعالجة</option>--}}
{{--                <option @if($key->status == 'done') selected @endif value="done">انتهت</option>--}}
{{--                <option @if($key->status == 'deleted') selected @endif value="deleted">محذوفة</option>--}}
{{--            </select>--}}
{{--            <header>--}}
{{--                <h1>{{ $key->note_text }}</h1>--}}
{{--            </header>--}}
{{--            <div class="content">--}}
{{--                <div class="hipsum">--}}
{{--                    <p>--}}
{{--                        {{ $key->note_description }}--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endforeach--}}

<div class="col-md-12">
    <table class="table table-hover table-bordered table-sm">
        <thead>
            <tr>
                <th>العنوان</th>
                <th>النص</th>
                <th style="width: 180px"></th>
                <th style="width: 100px">الحالة</th>
                <th style="width: 50px"></th>
            </tr>
        </thead>
        <tbody>
            @if($data->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">لا يوجد بيانات</td>
                </tr>
            @else
                @foreach($data as $key)
                    <tr id="tr_status_{{ $key->id }}" @if($key->status == 'deleted') class="bg-danger" @endif>
                        <td>{{ $key->note_text }}</td>
                        <td>{{ $key->note_description }}</td>
                        <td style="font-size: 14px;vertical-align: middle" class="text-bold">
                            <span style="font-size: 14px;" class="badge bg-warning mt-0">{{ \Carbon\Carbon::parse($key->insert_at)->toDateString() }}</span>
                            |
                            <span class="text-danger mb-0">{{ $key->user->name }}</span>
                        </td>
                        <td>
                            <select class="@if($key->status == 'new') bg-info @elseif($key->status == 'in_progress') bg-warning @elseif($key->status == 'done') bg-success @elseif($key->status == 'deleted') bg-danger @endif" onchange="updateStatus({{ $key->id }},this.value)" name="" id="">
                                <option @if($key->status == 'new') selected @endif value="new">جديدة</option>
                                <option @if($key->status == 'in_progress') selected @endif value="in_progress">قيد المعالجة</option>
                                <option @if($key->status == 'done') selected @endif value="done">انتهت</option>
                                <option @if($key->status == 'deleted') selected @endif value="deleted">محذوفة</option>
                            </select>
                        </td>
                        <td>
                            <button onclick="edit_note_book_modal({{ $key }})" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
