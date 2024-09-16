<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>جميع الاصناف</title>
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
    <table class="table" cellpadding="10">
        <tr>
            <th>Product name</th>
        </tr>
        @foreach($data as $key)
            <tr>
                <td>{{ $key->product_name_ar }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
