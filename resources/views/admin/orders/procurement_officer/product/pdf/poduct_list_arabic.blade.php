<html dir="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تفاصيل اصناف طلبية</title>
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

        .title {}

        table,
        td,
        th {
            border-collapse: collapse;
            border: 1px solid black;
        }

        table tr {
            color: white;
        }

        .table {
            padding-top: 150px;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }

        th {
            height: 70%;
        }
    </style>
</head>

<body>
    <div style="z-index: 11; position: absolute;top: 0;left: 0;width: 100%;right: 0;align-items: center">
        <img src="{{ asset('img/background/jelanco-background.png') }}" style="width: 100%"
            data-new_src="labels/80/images/image1.jpg">
    </div>
    <p class="title">Order : {{ $order->reference_number }}</p>

    <table style="width: 100%;border: none;text-align: center">
        <thead>
            <tr>
                <th></th>
                <th>اسم الصنف</th>
                <th>الكمية</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key)
                <tr>
                    <td>
                        <img src="{{ asset('storage/product/'.$key['product']->product_photo) ?? asset('img/no_img.jpeg')}}" style="width: 30px" alt="">
                    </td>
                    <td>{{ $key['product']->product_name_ar }}</td>
                    <td>{{ $key->qty }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
