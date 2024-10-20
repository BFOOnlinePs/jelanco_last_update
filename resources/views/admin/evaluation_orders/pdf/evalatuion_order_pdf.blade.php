<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>طباعة التقييمات</title>

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

        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            padding: 20px;
        }

        h4,
        h6 {
            margin-bottom: 20px;
            color: #000;
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            /* تقليل الـ padding لتصغير حجم العناصر */
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: middle;
            font-size: 0.8rem;
            /* تصغير حجم الخط */
        }

        .table th {
            background-color: #6c757d;
            /* لون secondary */
            color: white;
        }

        .table-responsive {
            overflow-x: auto;
        }

        /* Radio to checkmark */
        input[type="radio"] {
            display: none;
        }

        input[type="radio"]+label {
            font-size: 1.5em;
            color: lightgray;
            cursor: pointer;
        }

        input[type="radio"]:checked+label {
            color: green;
            /* لون الإشارة */
        }

        input[type="radio"]+label:before {
            content: "✔";
            font-size: 1em;
            display: inline-block;
            margin-right: 5px;
        }
    </style>



</head>

<body>
    <h2 style="text-align: center">تقييم طلبية</h2>
    <table style="width: 100%;text-align: center;border: #000 solid 1px ">
        <tr>
            <th style="width: 33%">اسم المورد</th>
            <th style="width: 33%">الرقم المرجعي</th>
            <th style="width: 33%">تاريخ الاضافة</th>
        </tr>
        <tr>
            <td>
                {{ $order->priceOffers[0]->supplier->name }}
            </td>
            <td>{{ $order->reference_number }}</td>
            <td>{{ $order->inserted_at }}</td>
        </tr>
    </table>
    @if (auth()->user()->user_role == 1)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('evaluation.evaluation_order_pdf', ['id' => $order->id]) }}"
                            class="btn btn-warning btn-sm"><span class="fa fa-print"></span></a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @foreach ($data as $evaluation)
        <div class="row" style="border: #000 solid 1px;padding: 10px;margin-top:10px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('evaluation.create_evaluation') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $order->id }}" name="order_id">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table style="width: 100%;text-align: center">
                                                        <tr>
                                                            <td style="text-align: right;width:33%">
                                                                تقييم بواسطة
                                                                <span>{{ $evaluation->user->role->name }}</span> :
                                                                <span>{{ $evaluation->user->name }}</span>
                                                            </td>
                                                            <td>
                                                                {{ ($evaluation->evaluation_value * 100) / $evaluation->criteria_sum_mark }}
                                                                / 100
                                                            </td>
                                                            <td style="text-align: left;width:33%">
                                                                {{ $evaluation->insert_at }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>اسم المعيار</th>
                                                <th style="width:10%">1</th>
                                                <th style="width:10%">2</th>
                                                <th style="width:10%">3</th>
                                                <th style="width:10%">4</th>
                                                <th style="width:10%">5</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($evaluation->evaluation_criteria as $key)
                                                <tr>
                                                    <td>{{ $key->criteria->name }}</td>
                                                    <td>
                                                        @if ($key->value == 1)
                                                            <b
                                                                style="font-size: 20px;padding:0px;margin:0px">&#10003;</b>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($key->value == 2)
                                                            <b
                                                                style="font-size: 20px;padding:0px;margin:0px">&#10003;</b>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($key->value == 3)
                                                            <b
                                                                style="font-size: 20px;padding:0px;margin:0px">&#10003;</b>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($key->value == 4)
                                                            <b
                                                                style="font-size: 20px;padding:0px;margin:0px">&#10003;</b>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($key->value == 5)
                                                            <b
                                                                style="font-size: 20px;padding:0px;margin:0px">&#10003;</b>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-12" style="width: 100%">
                                    <div class="form-group">
                                        <textarea style="width: 100%" @if (
                                            $evaluation->status == 'rated' ||
                                                (auth()->user()->role_id == 2 || auth()->user()->role_id == 9 || auth()->user()->role_id == 10)) disabled @endif
                                            onchange="update_notes_ajax({{ $evaluation->id }} , this.value)" name="notes" class="form-control" id=""
                                            cols="30" rows="3">{{ $evaluation->notes }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</body>

</html>
