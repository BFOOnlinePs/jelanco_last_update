<table class="table table-hover table-bordered table-sm">
            <thead>
            <tr>
                <th>العنوان</th>
                <th>النص</th>
                <th>تاريخ الادخال</th>
                <th>الحالة</th>
            </tr>
            </thead>
            <tbody>
            @if($data->isEmpty())
                <tr>
                    <td colspan="4" class="text-center">لا يوجد بيانات</td>
                </tr>
            @else
                @foreach($data as $key)
                    <tr @if($key->status == 'deleted') class="bg-danger" @endif>
                        <td>{{ $key->note_text }}</td>
                        <td>{{ $key->note_description }}</td>
                        <td>{{ \Carbon\Carbon::parse($key->insert_at)->toDateString() }}</td>
                        <td>
                            <select onchange="updateStatus({{ $key->id }},this.value)" name="" id="">
                                <option @if($key->status == 'new') selected @endif value="new">جديدة</option>
                                <option @if($key->status == 'in_progress') selected @endif value="in_progress">قيد المعالجة</option>
                                <option @if($key->status == 'done') selected @endif value="done">انتهت</option>
                                <option @if($key->status == 'deleted') selected @endif value="deleted">محذوفة</option>
                            </select>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
