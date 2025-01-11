<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>اصناف الطلبية</title>
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

        /*.title {*/
        /*    padding-top: 220px;*/
        /*}*/

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
<h4 class="title" style="text-align: right">{{ \Carbon\Carbon::now()->toDateString() }}</h4>
<h3>To: {{ $company->name }}</h3>
<h2 style="text-align: center;font-weight: bold"><u>NEW ORDER - {{ $order->reference_number }}</u></h2>
<p>Dear , {{ $company->contact_person }}</p>
<p>Please prepare the below mentioned order:</p>
{{--<p style="text-align: justify;--}}
{{--  text-justify: inter-word;">--}}
{{--    <br>--}}
{{--    We extend our heartfelt invitation and utmost respect for your participation in providing quotations for our pen and--}}
{{--    ruler products. We have full confidence in your competence and expertise in delivering high-quality services that--}}
{{--    align with our exacting standards. We consistently strive to enhance our offerings through collaboration with--}}
{{--    esteemed suppliers, embodying our commitment to building strong strategic partnerships. We eagerly anticipate--}}
{{--    receiving your offers, fully expecting them to reflect the uniqueness and efficiency that characterize your esteemed--}}
{{--    company.--}}

{{--    Please submit your price quotations at your earliest convenience, inclusive of all necessary details and relevant--}}
{{--    clarifications. We stand ready to support you and address any inquiries you may have.--}}
{{--</p>--}}
<table class="table" cellpadding="10">
    <tr>
        {{-- <th></th> --}}
        {{-- <th>barcode</th> --}}
        <th>#</th>
        <th>product name</th>
        <th>qty</th>
        <th>unit</th>
        <th style="width: 80px">price</th>
    </tr>
    @if($data->isEmpty())
        <tr>
            <td colspan="5" align="center">لا يوجد بيانات</td>
        </tr>
    @else
        @foreach($data as $key)
            <tr>
                <td>{{ $loop->index+1 }}</td>
                <td align="left" style="padding: 0 20px 0 20px;text-align: center">
                    <span style="font-weight: bold">
                                        {{ $key['product']->product_name_en }}
                    </span>
                </td>
                <td>{{ $key->qty }}</td>
                <td>{{ $key->unit->unit_name_en ?? '' }}</td>
                <td></td>
            </tr>
        @endforeach
    @endif
</table>
<htmlpagefooter name="page-footer">
    <div style="display: block;text-align:center">Page {PAGENO} of {nbpg}</div>
</htmlpagefooter>

</body>
</html>
