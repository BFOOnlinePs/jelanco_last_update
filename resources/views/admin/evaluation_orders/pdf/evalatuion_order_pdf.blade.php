<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>طباعة التقييمات</title>

    <style>
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
            padding: 10px;
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
    @if ($data->isEmpty())
        <div class="row">
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
                                            <h4>الرقم المرجعي للطلبية : <span>{{ $order->reference_number }}</span></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>اسم المعيار</th>
                                                <th>1</th>
                                                <th>2</th>
                                                <th>3</th>
                                                <th>4</th>
                                                <th>5</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($criteria as $key)
                                                <tr>
                                                    <td>{{ $key->name }}</td>
                                                    <td><input required type="radio"
                                                            name="criteria[{{ $key->id }}]" value="1">
                                                    </td>
                                                    <td><input required type="radio"
                                                            name="criteria[{{ $key->id }}]" value="2">
                                                    </td>
                                                    <td><input required type="radio"
                                                            name="criteria[{{ $key->id }}]" value="3">
                                                    </td>
                                                    <td><input required type="radio"
                                                            name="criteria[{{ $key->id }}]" value="4">
                                                    </td>
                                                    <td><input required type="radio"
                                                            name="criteria[{{ $key->id }}]" value="5">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12"
                                    style="width: 100%>
                                    <div class="form-group">
                                    <label for="">ملاحظات</label>
                                    <textarea name="notes" style="width: 100%" class="form-control" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">حفظ التقييم</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    @else
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
            <div class="row">
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
                                                        <h4>تقييم بواسطة
                                                            <span>{{ $evaluation->user->role->name }}</span> :
                                                            <span>{{ $evaluation->user->name }}</span>
                                                        </h4>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="float-right">
                                                            <span
                                                                class="badge badge-success">{{ ($evaluation->evaluation_value * 100) / $evaluation->criteria_sum_mark }}
                                                                / 100</span>
                                                        </h6>
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
                                                    <th>1</th>
                                                    <th>2</th>
                                                    <th>3</th>
                                                    <th>4</th>
                                                    <th>5</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($evaluation->evaluation_criteria as $key)
                                                    <tr>
                                                        <td>{{ $key->criteria->name }}</td>
                                                        <td><input @if (
                                                            $evaluation->status == 'rated' &&
                                                                (auth()->user()->role_id == 2 || auth()->user()->role_id == 9 || auth()->user()->role_id == 10)) disabled @endif
                                                                required type="radio"
                                                                name="criteria[{{ $key->criteria->id }}]"
                                                                @if ($key->value == 1) checked @endif
                                                                value="1">
                                                        </td>
                                                        <td><input @if (
                                                            $evaluation->status == 'rated' &&
                                                                (auth()->user()->role_id == 2 || auth()->user()->role_id == 9 || auth()->user()->role_id == 10)) disabled @endif
                                                                required type="radio"
                                                                name="criteria[{{ $key->criteria->id }}]"
                                                                @if ($key->value == 2) checked @endif
                                                                value="2">
                                                        </td>
                                                        <td><input @if (
                                                            $evaluation->status == 'rated' ||
                                                                (auth()->user()->role_id == 2 || auth()->user()->role_id == 9 || auth()->user()->role_id == 10)) disabled @endif
                                                                required type="radio"
                                                                name="criteria[{{ $key->criteria->id }}]"
                                                                @if ($key->value == 3) checked @endif
                                                                value="3">
                                                        </td>
                                                        <td><input @if (
                                                            $evaluation->status == 'rated' ||
                                                                (auth()->user()->role_id == 2 || auth()->user()->role_id == 9 || auth()->user()->role_id == 10)) disabled @endif
                                                                required type="radio"
                                                                name="criteria[{{ $key->criteria->id }}]"
                                                                @if ($key->value == 4) checked @endif
                                                                value="4">
                                                        </td>
                                                        <td><input @if (
                                                            $evaluation->status == 'rated' ||
                                                                (auth()->user()->role_id == 2 || auth()->user()->role_id == 9 || auth()->user()->role_id == 10)) disabled @endif
                                                                required type="radio"
                                                                name="criteria[{{ $key->criteria->id }}]"
                                                                @if ($key->value == 5) checked @endif
                                                                value="5">
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
                                                onchange="update_notes_ajax({{ $evaluation->id }} , this.value)" name="notes" class="form-control"
                                                id="" cols="30" rows="3">{{ $evaluation->notes }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</body>

</html>
