<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تقرير مورد مفصل</title>
    <style>
        html {
            position: relative;
        }
        body {
            background-color: rgb(255, 255, 255);
            position: relative;
            margin: 0;
            padding: 0;
            width: 82mm;
            height: 106mm;
        }

        @page :first {
            margin-bottom: 50px;
            margin-top: 220px;
        }

        @page {
            margin-bottom: 50px;
            size: 10cm 20cm landscape;
        }


        /*@page :first {*/
        /*    background-image-resize: 1;*/
        /*    background-size: cover;*/
        /*    background-repeat: no-repeat;*/
        /*    margin-bottom: 50px;*/
        /*    margin-top: 220px;*/
        /*}*/

        .page-break {
            page-break-after: always;
        }

        .title {
            text-align: center;
        }

        table, td, th {
            border: 1px solid black;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }

        th {
            height: 70%;
        }

        .header_order tr td{
            border: none;text-align: left;width: 33%;font-weight: bold;
            font-size: 20px;
        }
    </style>
</head>
<body>
<div style="z-index: 11; position: absolute;top: 0;left: 0;width: 100%;right: 0;align-items: center">
    <img src="{{ asset('img/background/jelanco-background.png') }}" style="width: 100%" data-new_src="labels/80/images/image1.jpg">
</div>
<p class="title">Supplier report</p>
<h1 class="title">{{ $supplier->name }}</h1>

@foreach($data as $key)
<?php
$sum = 0;
$discount = 0;
?>
    @if(!$key['product']->isEmpty())
        <div>
            <table class="header_order" style="width: 100%;border: none;text-align: center">
                <tr>
                    <td style="text-align: left;font-size: 17px">R.N : <span>{{ $key->reference_number }}</span></td>
                    <td style="text-align: right;font-size: 17px"><span style="background-color: black;color: white;padding-right: 10px;padding-left: 10px">&nbsp;{{ \App\Models\OrderStatusModel::where('id',$key->order_status)->value('name') }}&nbsp;</span></td>
                </tr>
                <tr style="border: none;text-align: center">
                    <td style="text-align: left;font-size: 16px">Currency : <span>{{ \App\Models\CurrencyModel::where('id',$key->currency_id)->value('currency_name') }}</span></td>
                    <td style="text-align: right;font-size: 16px">{{ $key->inserted_at }}</td>
                </tr>
            </table>
        </div>
        <table style="width: 100%" cellspacing="0">
            @if(!($key['product']->isEmpty()))
                <tr>
                    <th width="80"></th>
                    <th width="300">Product</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    {{-- <th>Unit Price</th> --}}
                    {{-- <th>Bonus</th> --}}
                    {{-- <th>Discount %</th> --}}
                    {{-- <th>Total price</th> --}}
                </tr>
                @foreach($key['product'] as $child)
                    @php
                        $sum += (double)(\App\Models\OrderItemsModel::where('order_id',$key->order_id)->where('product_id',$child->id)->value('qty')) * (double)($child->price);
                        $discount += (($child->price * \App\Models\OrderItemsModel::where('order_id',$key->order_id)->where('product_id',$child->id)->value('qty')) * $child->discount_present) / 100;
                        // $final_discount_result += ((double)$child->qty * (double) \App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$child->product_id)->where('supplier_id',$key['supplier']->id)->value('price') * (double)\App\Models\PriceOfferItemsModel::where('order_id',$key->order_id)->where('product_id',$child->product_id)->where('supplier_id',$key['supplier']->id)->value('discount_present')) / 100 ;
                    @endphp
                    <tr>
                        <td width="50" align="center">
                            @if(empty($child->product_photo))
                                <img style="width: 50px" src="{{ asset('img/no_img.jpeg') }}" alt="">
                            @else
                                <img style="width: 50px"
                                     src="{{ asset('storage/product/'.$child->product_photo) }}" alt="">
                            @endif
                        </td>
                        <td width="300">{{ $child->product_name_ar }}</td>
                        <td style="text-align: center">{{ \App\Models\OrderItemsModel::where('order_id',$key->order_id)->where('product_id',$child->id)->value('qty') }}</td>
                        <td style="text-align: center">{{ \App\Models\UnitsModel::where('id',$child->unit_id)->value('unit_name') }}</td>
                        {{-- <td style="text-align: center">{{ $child->price }}</td>
                        <td style="text-align: center">{{ $child->bonus }}</td>
                        <td style="text-align: center"><span style="font-size: 10px">(%{{ $child->discount_present }})</span> <br> <span style="font-size: 14px">{{ (($child->price * \App\Models\OrderItemsModel::where('order_id',$key->order_id)->where('product_id',$child->id)->value('qty')) * $child->discount_present) / 100}}</span></td>
                        <td style="text-align: center">{{(double)(\App\Models\OrderItemsModel::where('order_id',$key->order_id)->where('product_id',$child->id)->value('qty')) * (double)($child->price) }}</td> --}}
                    </tr>
                @endforeach
                {{-- <tr>
                    <td colspan="6" style="text-align: center;font-weight: bold">Total</td>
                    <td style="text-align: center">{{ $discount }}</td>
                    <td style="text-align: center">{{ $sum }}</td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align: center;font-weight: bold">Total after discount</td>
                    <td colspan="2" style="text-align: center">{{ $sum - $discount }}</td>
                </tr> --}}
            @else
                <tr style="border: none">
                    <td colspan="3">
                        لا توجد اصناف
                    </td>
                </tr>
            @endif
        </table>
        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endif
@endforeach
</body>
</html>
