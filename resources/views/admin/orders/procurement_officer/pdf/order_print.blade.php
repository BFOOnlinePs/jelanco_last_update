<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>طباعة طلبيات</title>
    <style>
        .order_table table, td, th {
            border: 1px solid #ddd;
            text-align: center;
            font-size: 15px;
        }

        .order_table th, td {
            padding: 10px;
        }

        .order_table{
            border-collapse: collapse;
            width: 100%;
        }

        .order_filter_table{
            border: 1px solid #ddd;
            text-align: center;
            margin-bottom: 30px;
            width: 100%;
            border-collapse: collapse;
        }

        .order_filter_table tr td{
            font-size: 15px;
        }
    </style>
</head>
<body>
    @if($request->print_type == 'with_filter')
        <table class="order_filter_table">
            <tr style="font-size: 5px;">
                <th>الرقم المرجعي</th>
                <th>اسم المورد</th>
                <th>متابعة بواسطة</th>
                <th>مجال العمل</th>
                <th>حالة الطلبية</th>
                <th>من تاريخ</th>
                <th>الى تاريخ</th>
            </tr>
            <tr >
                <td>{{ $order_table_request['reference_number'] }}</td>
                <td>{{ $order_table_request['supplier_id']->name ?? '' }}</td>
                <td>{{ $order_table_request['to_user']->name ?? '' }}</td>
                <td></td>
                <td>{{ $order_table_request['order_status']->name ?? '' }}</td>
                <td>{{ $order_table_request['from'] ?? '' }}</td>
                <td>{{ $order_table_request['to'] ?? '' }}</td>
            </tr>
        </table>
    @endif
    <table class="table order_table table-bordered table-hover dataTable dtr-inline"
    >
        <thead>
        <tr>
            {{--                <th>رقم طلبية الشراء</th>--}}
            <th style="width: 10%">#</th>
            <th style="width: 170px">الرقم المرجعي للطلبية</th>
            <th style="width: 30%">الترسية</th>
            <th style="width: 30%">مجال العمل</th>
            <th style="width: 180px">متابعة بواسطة</th>
            <th style="width: 150px">تاريخ الطلبية</th>
            <th style="width: 200px">حالة الطلبية</th>
        </tr>
        </thead>
        <tbody>
        @if($data->isEmpty())
            <tr>
                <td colspan="7" class="text-center"><h3 class="p-5">لا توجد نتائج</h3></td>
            </tr>
        @else
            @foreach($data as $key)
                <tr class="">
                    {{--                    <td>{{ $key->id }}</td>--}}
                    {{--                    <td>{{ $key->order_id }}</td>--}}
                    <td>{{ ($data ->currentpage()-1) * $data ->perpage() + $loop->index + 1 }}</td>
                    <td>{{ $key->reference_number }}
                        @if(auth()->user()->user_role != 3 && auth()->user()->user_role != 9)
                            <span onclick="getReferenceNumber({{ $key->id }})" class="fa fa-edit text-success"
                                  style="float: left" data-toggle="modal"
                                  data-target="#modal-reference_number"></span>
                        @endif
                    </td>
                    <td>
                        @if($view == 'officer_view' || auth()->user()->user_role == 9)
                            @foreach($key->supplier as $child)
                                <span>{{ $child['name']->name }},</span>
                            @endforeach
                        @else
                            @foreach($key->supplier as $child)
                                {{ $child['name']->name }}
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @foreach($key->supplier as $child)
                                @if(!empty($child->user_categories))
                                    {{ implode(', ', $child->user_categories) }}
                                @else
                                    empty
                                @endif
                            @endforeach
                    </td>
                    <td>
                        {{ $key['to_user']->name }}
                    </td>
                    <td>
                        {{ $key->inserted_at }}
                        @if (auth()->user()->user_role != 9)
                            <span onclick="showDueDate({{ $key->id }})" class="fa fa-edit text-success"
                                  style="float: left" data-toggle="modal" data-target="#modal-show_due_date"></span>
                        @endif
                    </td>
                    <td>
                        {{ $key->order_status_color->name }}
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</body>
</html>
