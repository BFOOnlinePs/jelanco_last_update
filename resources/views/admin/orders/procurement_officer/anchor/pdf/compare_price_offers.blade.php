<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>عرض سعر طلبية {{$order->id}}</title>
    <style>
        @page{
            background-image: url("{{ asset('img/background/jelanco-background.jpg') }}");
            background-image-resize:6;
            margin-top:220px;
            margin-bottom:50px;
        }

        @page :first{
            background-image: url("{{ asset('img/background/jelanco-background.jpg') }}");
            background-image-resize:6;
            margin-bottom:50px;
            margin-top:220px;
        }
        .title{

        }
        table, td, th {
            border: 1px solid black;
        }
        .table{
            padding-top: 150px;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }
        th{
            height: 70%;
        }
    </style>

</head>
<body>
    <table cellpadding="5" class="table table-sm table-hover table-bordered">
    <thead>
    <tr>
        <th>الاصناف</th>
        <th>الكمية</th>
        @php
            $colCount = -1;
        @endphp
        @foreach($query as $user)

            @foreach($user->user_name as $key)
                <th>{{ $key->name }}</th>

            @endforeach
            @php
                $colCount ++;
                $sum[$colCount] = 0;
            @endphp
        @endforeach
    </tr>
    </thead>
    <tbody>

    @foreach($order_items as $order_item)
        <tr>
            <td>{{ $order_item['product']->product_name_ar }}</td>
            <td>{{ $order_item->qty }}</td>
            @php
                $col = 0;
            @endphp
            @php
                $counter = 0;
            @endphp
            @foreach($query as $user)
                @foreach($user->user_name as $key)
                    <td>{{  $price = \App\Models\PriceOfferItemsModel::where('order_id',$order_item->order_id)->where('supplier_id',$key->id)->where('product_id',$order_item->product_id)->value('price') }}
                        ({{ $total =  (double)($price * $order_item->qty) }})
                        @php $sum[$counter] += $total @endphp
                    </td>
                    @php
                        $counter++;
                    @endphp
                @endforeach
                @php
                    $col++;
                @endphp
            @endforeach
        </tr>
    @endforeach
    <tr>
        <td colspan="2" class="text-center bg-dark">المجموع</td>
        @php
            $counter = 0;
        @endphp
        @foreach($query as $user)
            @foreach($user->user_name as $key)
                <td>{{ $sum[$counter] }}</td>
                @php
                    $counter++;
                @endphp
            @endforeach
        @endforeach
    </tr>
    </tbody>
</table>
</body>
</html>
