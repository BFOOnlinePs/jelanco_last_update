<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تقرير حسب الشركة</title>
    <style>
        @page {
            background-image: url("{{ asset('img/background/jelanco-background.jpg') }}");
            background-image-resize: 6;
            margin-top: 220px;
            margin-bottom: 50px;
        }

        @page :first {
            background-image: url("{{ asset('img/background/jelanco-background.jpg') }}");
            background-image-resize: 6;
            margin-bottom: 50px;
            margin-top: 220px;
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
    </style>
</head>
<body>
<h1 class="title">{{ $supplier->name }}</h1>
<table class="table" cellpadding="10">
    <tr>
        <th>Product image</th>
        <th>Product name</th>
        <th>Product name en</th>
        <th>Barcode</th>
    </tr>
    @foreach($data as $key)
        <tr>
            <td>
                @if(empty($key->product_photo))
                    <img width="70" src="{{ asset('img/no_img.jpeg') }}" alt="">
                @else
                    <img width="100" src="{{ asset('storage/product/'.$key->product_photo) }}" alt="">
                @endif
            </td>
            <td>{{ $key->product_name_ar }}</td>
            <td>{{ $key->product_name_en }}</td>

            <td>{{ $key->barcode }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
