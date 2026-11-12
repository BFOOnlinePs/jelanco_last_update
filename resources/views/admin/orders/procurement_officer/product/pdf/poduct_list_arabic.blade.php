
<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

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

        .page-break {
            page-break-after: always;
        }

        .title {
            text-align: center;
        }

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

        .product-image {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }
    </style>
</head>

<body>

    <div style="z-index: 11; position: absolute; top: 0; left: 0; width: 100%; right: 0; align-items: center">

        <img
            src="{{ public_path('img/background/jelanco-background.png') }}"
            style="width: 100%"
        >

    </div>

    <p class="title">
        Order : {{ $order->reference_number }}
    </p>

    <table style="width: 100%; border: none; text-align: center">

        <thead>
            <tr>
                <th></th>
                <th>اسم الصنف</th>
                <th>الكمية</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($data as $key)

                @php
                    $imagePath = public_path('storage/product/' . ($key->product->product_photo ?? ''));

                    $imageExists = !empty($key->product->product_photo)
                        && file_exists($imagePath);

                    if (!$imageExists) {
                        $imagePath = public_path('img/no_img.jpeg');
                    }
                @endphp

                <tr>

                    <td>
                        <img
                            src="{{ $imagePath }}"
                            class="product-image"
                            width="30"
                            height="30"
                            alt=""
                        >
                    </td>

                    <td>
                        {{ $key->product->product_name_ar ?? '' }}
                    </td>

                    <td>
                        {{ $key->qty }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</body>
</html>
