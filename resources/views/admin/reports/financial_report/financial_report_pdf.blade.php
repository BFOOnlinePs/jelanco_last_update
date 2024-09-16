<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تقرير الدفع المالية</title>
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
    </style>
</head>
<body>
<h1 class="title">Cash Payment</h1>
@if(!empty($cash_payment))
    <table class="table" cellpadding="10">
        <tr>
            <th>Order number</th>
            <th>Supplier name</th>
            <th>Price</th>
            <th>Payment date</th>
        </tr>

        @foreach($cash_payment as $key)
            <tr>
                <td>{{ $key->order_id }}</td>
                <td>{{ $user }}</td>
                <td>{{ $key->amount }}</td>
                <td>{{ $key->payment_date }}</td>
            </tr>
        @endforeach
    </table>
@endif
@if(!empty($letter_bank))
    <div class="page-break"></div>
@endif
<h1 class="title">Letter Bank</h1>
@if(!empty($letter_bank))
    <table class="table" cellpadding="10">
        <tr>
            <th>Price</th>
            <th>Bank</th>
            <th>Due date</th>
            <th>Notes</th>
        </tr>

        @foreach($letter_bank as $key)
            <tr>
                <td>{{ $key->letter_value }}</td>
                <td>{{ $key->bank->user_bank_name }}</td>
                <td>{{ $key->amount }}</td>
                <td>{{ $key->payment_date }}</td>
            </tr>
        @endforeach
    </table>
@endif
</body>
</html>
