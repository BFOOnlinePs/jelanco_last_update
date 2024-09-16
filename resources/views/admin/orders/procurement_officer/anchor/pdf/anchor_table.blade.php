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

@foreach($anchor as $key)
    @if($key->id == $price_offer)

        <div class="col-md-12 col-sm-6 col-12">
        <div class="info-box bg-success">
            <div class="info-box-content">
                <div class="row">
                    <div class="col-md-11">
                        <span class="info-box-text">{{ $key['supplier']->name }}</span>
                        <span class="progress-description">
{{ $key->notes }}
</span>
                    </div>
                    <div class="table-responsive mt-2">
                            <table cellpadding="3" class="table bg-white table-bordered table-hover table-sm text-center">
                                <thead>
                                <tr>
                                    <th>الرقم</th>
                                    <th>الصورة</th>
                                    <th>اسم الصنف</th>
                                    <th>الكمية</th>
                                    <th>الوحدة</th>
                                    <th>السعر</th>
                                    <th>الاجمالي</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sum = 0;
                                @endphp
                                @foreach($order_items as $order_item)
                                    @php
                                        $sum += (double)$order_item->qty * (double) \App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('price')
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            @if(empty($order_item['product']->product_photo))
                                                <img width="100" src="{{ asset('img/no_img.jpeg') }}" alt="">
                                            @else
                                                <img width="100"
                                                     src="{{ asset('storage/product/'.$order_item['product']->product_photo) }}"
                                                     alt="">
                                            @endif
                                        </td>
                                        <td>{{ $order_item['product']->product_name_ar }}</td>
                                        <td>{{ $order_item->qty }}</td>
                                        <td>{{ $order_item['unit']->unit_name }}</td>
                                        <td>
                                                        <span>
                                                            {{ (double)\App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('price') }}
                                                        </span>
                                        </td>
                                        <td>
                                           {{ (double)$order_item->qty * (double) \App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$order_item->product_id)->where('supplier_id',$key['supplier']->id)->value('price') }}
                                            <br>{{ $key['currency']->currency_name }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" class="text-center bg-dark">المجموع</td>
                                    <td class="text-center bg-warning" dir="ltr">{{ $sum }} {{ $key['currency']->currency_name }}</td>
                                </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</span>

    @endif
@endforeach

</body>
</html>
