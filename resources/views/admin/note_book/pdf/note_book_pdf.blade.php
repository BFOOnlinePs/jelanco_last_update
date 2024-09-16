<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ملاحظاتي</title>
    <style>
        @page {
            background-image: url("{{ asset('img/background/jelanco-background.jpg') }}");
            background-image-resize: 6;
            margin-top: 220px;
            margin-bottom: 50px;
            footer: page-footer;
        }

        @page :first {
            background-image: url("{{ asset('img/background/jelanco-background.jpg') }}");
            background-image-resize: 6;
            margin-bottom: 50px;
            margin-top: 220px;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        /*tr:nth-child(even) {*/
        /*    background-color: #dddddd;*/
        /*}*/
    </style>
</head>
<body>
    <table>
        <tr>
            <th>العنوان</th>
            <th>النص</th>
            <th>تاريخ الادخال</th>
            <th>الحالة</th>
        </tr>
        @foreach($data as $key)
            <tr>
                <td>{{ $key->note_text }}</td>
                <td>{{ $key->note_description }}</td>
                <td>{{ \Carbon\Carbon::parse($key->insert_at)->toDateString() }}</td>
                <td>
                    @if($key->status == 'new')
                        جديد
                    @elseif($key->status == 'in_progress')
                        قيد المعالجة
                    @elseif($key->status == 'done')
                        انتهت
                    @elseif($key->status == 'deleted')
                        محذوفة
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>
