<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تقرير مورد</title>
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

        table tr th{
            color: white;
        }

        th {
            height: 70%;
        }
    </style>
</head>
<body>
<h1 class="title">{{ $supplier->name }}</h1>
<table class="table" cellpadding="10">
    <tr style="background-color: black">
        <th>Reference number</th>
        <th>Order status</th>
        <th>Order date</th>
    </tr>

    @foreach($data as $key)
        @if($key->order_status != -1)
            <tr>
                <td>{{ $key->reference_number }}</td>
                <td>
                    @if($key->progress_status == 1)
                        الاصناف
                    @elseif($key->progress_status == 2)
                        عروض الاسعار
                    @elseif($key->progress_status == 3)
                        الترسية
                    @elseif($key->progress_status == 4)
                        الملف المالي
                    @elseif($key->progress_status == 5)
                        الشحن
                    @elseif($key->progress_status == 6)
                        تأمين
                    @elseif($key->progress_status == 7)
                        تخليص
                    @elseif($key->progress_status == 8)
                        توصيل
                    @endif
                </td>
                <td>{{ $key->created_at }}</td>
            </tr>
        @endif
    @endforeach

</table>
</body>
</html>
