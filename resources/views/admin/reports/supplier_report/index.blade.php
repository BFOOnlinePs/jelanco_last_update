<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>قائمة الموردين</title>
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

        table tr th {
            color: white;
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
    <tr style="background-color: black;">
        <th>Supplier name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Orders</th>
    </tr>
    @foreach($data as $key)
        <tr>
            <td style="text-align: left;width: 50%">{{ $key->name }}</td>
            <td style="text-align: left">{{ $key->email }}</td>
            <td style="text-align: left">{{ $key->user_phone1 }}</td>
            <td>{{ $key->count }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
