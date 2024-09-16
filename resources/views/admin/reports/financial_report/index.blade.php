@extends('home')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="card bg-info">
        <div class="card-body">
{{--            <form action="{{ route('reports.financial_report.financial_report_PDF') }}" method="post">--}}
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">الموردين</label>
                            <select onchange="data_table_ajax()" name="supplier_id" id="supplier_id" class="form-control select2bs4">
                                <option value="">جميع الموردين</option>
                                @foreach($suppliers as $key)
                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="">من تاريخ</label>
                            <input onchange="data_table_ajax()" name="from" id="from_date" value="<?php echo '2023-01-01'?>" type="text" class="form-control date_format">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="">الى تاريخ</label>
                            <input onchange="data_table_ajax()" name="to" id="to_date" value="<?php echo date('Y-m-d')?>" type="text" class="form-control date_format">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="">نوع التقرير</label>
                            <select onchange="data_table_ajax()" name="report_type" id="report_type" class="form-control">
                                <option value="all">الجميع</option>
                                <option value="financial">دفعات نقدية</option>
                                <option value="letter_bank">اعتمادات بنكية</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="">حالة الدفعة</label>
                            <select onchange="data_table_ajax()" class="form-control" name="" id="payment_status">
                                <option value="">الكل</option>
                                <option value="0">بانتظار الدفع</option>
                                <option value="1">مدفوعة</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="">بواسطة</label>
                            <select onchange="data_table_ajax()" class="form-control select2bs4" name="" id="insert_by">
                                <option value="">الكل</option>
                                @foreach($users as $key)
                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
{{--            </form>--}}
        </div>
    </div>
    <div id="data_table_ajax">

    </div>
{{--    <div class="card">--}}
{{--        <div class="card-body">--}}
{{--            --}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
    <script>
        function data_table_ajax(page,type,order_by,order_by_type){
            // alert('asd');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('data_table_ajax').innerHTML = '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '{{ route('reports.financial_report.financial_report_data_filter_ajax') }}',
                method: 'post',
                data: {
                    'supplier_id': document.getElementById('supplier_id').value,
                    'from_date': document.getElementById('from_date').value,
                    'to_date': document.getElementById('to_date').value,
                    'report_type': document.getElementById('report_type').value,
                    'payment_status': document.getElementById('payment_status').value,
                    'insert_by': document.getElementById('insert_by').value,
                    'page': page,
                    'type': type,
                    'order_by': order_by,
                    'order_by_type': order_by_type
                },
                headers: headers,
                success: function (data) {
                    console.log(data);
                    $('#data_table_ajax').html(data.view);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        window.onload = function () {
            data_table_ajax(pageCashPayment, 'cash_payment');
            data_table_ajax(pageLetterBank, 'letter_bank');

            $('.pagination-cash-payment a').addClass('your-custom-class-for-cash-payment');
            $('.pagination-letter-bank a').addClass('your-custom-class-for-letter-bank');
        }

        var pageCashPayment = 1;
        var pageLetterBank = 1;


        function updateCashPaymentPagination(page) {
            pageCashPayment = page;
            data_table_ajax(pageCashPayment, 'cash_payment');
        }

        function updateLetterBankPagination(page) {
            pageLetterBank = page;
            data_table_ajax(pageLetterBank, 'letter_bank');
        }

        $(document).on('click', '.pagination-cash-payment a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            updateCashPaymentPagination(page);
        });

        $(document).on('click', '.pagination-letter-bank a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            updateLetterBankPagination(page);
        });
    </script>
@endsection
