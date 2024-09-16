@extends('home')
@section('title')
    فواتير المشتريات
@endsection
@section('header_title')
    فواتير المشتريات
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    فواتير المشتريات
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <style>
        .search_table th {
            text-align: center
        }

        .search_table td {
            text-align: center
        }

        .search_table td input {
            width: 90px;
            text-align: center
        }
    </style>
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">

        {{-- <div class="card-header">
            <h3 class="text-center">قائمة البنوك</h3>
        </div> --}}

        <div class="card-body">
            {{-- <div class="row">
                <div class="col-md-6">
                    <div class="p-1">
                        <span style="font-size: 25px" class="bg-dark p-1">فاتورة رقم #{{ $data->id }}</span>
                    </div>
                    <div class="p-1">
                        <span>تاريخ الفاتورة : {{ $data->bill_date }}</span>
                    </div>
                    <div class="p-1">
                        <span>تاريخ التسليم : {{ $data->due_date }}</span>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
            </div> --}}
            @if($purchase_invoice->order_id != null)
                <div class="row text-center">
                    <div class="col-md-12 alert alert-info">
                        تم انشاء هذه الفاتورة استناداً لطلبية رقم <a href="{{ route('procurement_officer.orders.product.index',['order_id'=>$purchase_invoice->order_id]) }}" class="btn btn-dark btn-sm">{{ $purchase_invoice->order->reference_number }}</a> وتم اضافة التاريخ بشكل تلقائي
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                       <div class="col-md-3">
                            <div class="form-group">
                                <?php
                                $month = date('m');
                                $day = date('d');
                                $year = date('Y');
                                $today = $year . '-' . $month . '-' . $day;
                                ?>
                                <label for="">تاريخ الفاتورة</label>
                                <input onchange="update_purchase_invoices_from_ajax('bill_date',this.value)" type="date" name="bill_date" class="form-control text-center"
                                    value="{{ $purchase_invoice->bill_date }}">
                            </div>
                        </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <?php
                            $month = date('m');
                            $day = date('d');
                            $year = date('Y');
                            $today = $year . '-' . $month . '-' . $day;
                            ?>
                            <label for="">تاريخ الاستحقاق</label>
                            <input onchange="update_purchase_invoices_from_ajax('due_date',this.value)" type="date" name="due_date" class="form-control text-center"
                                value="{{ $purchase_invoice->due_date }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">الضريبة الاولى</label>
                            <select onchange="update_purchase_invoices_from_ajax('tax_id',this.value)" required name="tax_id" id="tax_id1" class="form-control select2bs4">
                                <option value="">اختر قيمة الضريبة ...</option>
                                @foreach ($taxes as $key)
                                    <option @if($key->id == $purchase_invoice->tax_id) selected @endif value="{{ $key->id }}">{{ $key->tax_name }} ({{ $key->tax_ratio }}%)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">الضريبة الثانية</label>
                            <select onchange="update_purchase_invoices_from_ajax('tax_id2',this.value)" required name="tax_id2" id="tax_id2" class="form-control select2bs4">
                                <option value="">اختر قيمة الضريبة ...</option>
                                @foreach ($taxes as $key)
                                    <option @if($key->id == $purchase_invoice->tax_id2) selected @endif value="{{ $key->id }}">{{ $key->tax_name }} ({{ $key->tax_ratio }}%)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="checkbox" id="checkbox" onchange="if_checked(this.value)">
                            <label for="checkbox">فاتورة دورية</label>
                        </div>
                    </div>
                    <div style="display: none" id="recurring_form" class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">التكرار خلال</label>
                                    <input onchange="update_purchase_invoices_from_ajax('repeat_every',this.value)" value="{{ $purchase_invoice->repeat_every }}" type="text" name="repeat_every" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">خلال</label>
                                    <select onchange="update_purchase_invoices_from_ajax('repeat_type',this.value)" class="form-control" name="repeat_type" id="">
                                        <option @if($purchase_invoice->repeat_type == 'days') selected @endif value="days">يوم</option>
                                        <option @if($purchase_invoice->repeat_type == 'weeks') selected @endif value="weeks">اسبوع</option>
                                        <option @if($purchase_invoice->repeat_type == 'months') selected @endif value="months">شهر</option>
                                        <option @if($purchase_invoice->repeat_type == 'years') selected @endif value="years">سنة</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">الدورة</label>
                                    <input value="{{ $purchase_invoice->no_of_cycles }}" type="text" onchange="update_purchase_invoices_from_ajax('no_of_cycles',this.value)" name="no_of_cycles" class="form-control" placeholder="الدورة">
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">ملاحظات</label>
                            <textarea class="form-control" name="note" onchange="update_purchase_invoices_from_ajax('note',this.value)" id="" cols="30" rows="3">{{ $purchase_invoice->note }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-3 card bg-warning">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="from-group">
                                    <label for="">الرقم المرجعي للفاتورة</label>
                                    <input type="text" onchange="update_invoice_reference_number_ajax(this.value)" class="form-control" value="{{ $purchase_invoice->invoice_reference_number }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">العميل</label>
                                    <select disabled name="client_id" id="" class="form-control select2bs4">
                                        <option value="">اختر عميل ...</option>
                                        @foreach ($users as $key)
                                            <option @if($key->id == $purchase_invoice->client_id) selected @endif value="{{ $key->id }}">{{ $key->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">حالة الفاتورة</label>
                                    <select name="" class="form-control" id="">
                                        <option value="">اختر حالة الفاتورة ...</option>
                                        <option value="">فاتورة جديدة غير مرحلة</option>
                                        <option value="">فاتورة مرحلة</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
            <hr>
            <button onclick="show_form_product()" type="button" id="add_product" class="btn btn-info mb-2">
                اضافة صنف
            </button>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div id="invoices_table">

                    </div>
                </div>
            </div>
            <div style="position: fixed; left: 20px; bottom: 20px;height:500px" id="toastsContainerBottomLeft"
                class="toasts-bottom-left fixed">
                <div class="toast fade" style="background-color:rgba(255,255,255,.85);" id="form_product" role="alert"
                    aria-live="assertive" aria-atomic="true" style="width: 100%; height: 100%;">
                    <div class="toast-header">
                        <strong class="mr-auto">قائمة الأصناف</strong>
                        <button type="button" class="ml-2 mb-1 close" onclick="close_form_product()">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        <input type="text" id="search_product" onkeyup="search_product_ajax(this.value)"
                            class="form-control" placeholder="بحث عن عنصر">
                        <div style="width: 300px;display:block" class="mt-2">
                            <div id="search_product_table">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="discount-modal">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('accounting.texes.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">الضريبة</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">قيمة الضريبة</label>
                                    <select class="form-control" name="" id="tax_ratio">
                                        <option value="">لا يوجد ضريبة</option>
                                        @foreach($taxes as $key)
                                            <option value="{{$key->id}}">{{ $key->tax_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">نوع الضريبة</label>
                                    <select class="form-control" name="" id="tax_type">
                                        <option value="before">الاسعار شامل الضريبة</option>
                                        <option value="after">الضريبة تضاف على المجموع</option>
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="{{ $data->tax->tax_ratio??'' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="form-control" name="" id="">
                                                <option value="">مئوية (%)</option>
                                                <option value="">ثابتة</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                        <button onclick="update_tax_type()" type="button" class="btn btn-primary">حفظ</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection()

@section('script')
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        function show_form_product() {
            document.getElementById('form_product').classList.add('show');
            document.getElementById('form_product').style.display = 'block';
        }

        function close_form_product() {
            document.getElementById('form_product').classList.remove('show');
            document.getElementById('form_product').style.display = 'none';
        }

        function search_product_ajax(search_product,page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.purchase_invoices.search_product_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'search_product': search_product,
                    'invoice_id': {{ $purchase_invoice->id }},
                    'page': page
                },
                success: function(data) {
                    console.log(data);
                    $('#search_product_table').html(data.view);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function invoices_table() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('invoices_table').innerHTML =
                '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '{{ route('accounting.purchase_invoices.invoice_table') }}',
                method: 'post',
                headers: headers,
                data: {
                    'invoice_id': {{ $data->id }},
                },
                success: function(data) {
                    // console.log(data);
                    $('#invoices_table').html(data.view);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function create_product_ajax(index) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.purchase_invoices.create_product_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'item_id': document.getElementById('item_id_' + index).value,
                    'invoice_id': {{ $data->id }}
                },
                success: function(data) {
                    console.log(data.view);
                    invoices_table();
                    search_product_ajax(document.getElementById('search_product').value,page);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function delete_item(id) {
            var message_result = confirm('هل تريد حذف العنصر ؟');
            if (message_result) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '{{ route('accounting.purchase_invoices.delete_item') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'id': id,
                    },
                    success: function(data) {
                        invoices_table();
                        toastr.success('تم حذف العنصر بنجاح')
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            }
        }

        function edit_inputs_from_invoice(id, value, operation) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };

            $.ajax({
                url: '{{ route('accounting.purchase_invoices.edit_inputs_from_invoice') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'operation': operation,
                    'value': value
                },
                success: function(data) {
                    updateTotal(id);
                    updateSubTotal();
                    toastr.success('تم التعديل بنجاح');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_invoice_reference_number_ajax(value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };

            $.ajax({
                url: '{{ route('accounting.purchase_invoices.update_invoice_reference_number_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': {{ $purchase_invoice->id }},
                    'invoice_reference_number': value
                },
                success: function(data) {
                    if(data.status == 'true'){
                        toastr.success(data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_purchase_invoices_from_ajax(operation,value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.purchase_invoices.update_purchase_invoices_from_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id':{{ $purchase_invoice->id }},
                    'operation': operation,
                    'value': value
                },
                success: function(data) {
                    console.log(data);
                    toastr.success(data.message)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_taxes_ajax(tax_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.purchase_invoices.update_purchase_invoices_from_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'tax_id': tax_id,
                },
                success: function(data) {
                    console.log(data);
                    toastr.success(data.message)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_tax_id_ratio() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.purchase_invoices.update_tax_id_ratio') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': {{ $purchase_invoice->id }},
                    'tax_id': document.getElementById('tax_ratio').value,
                },
                success: function(data) {
                    console.log(data);
                    toastr.success(data.message)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        $(document).ready(function() {
            document.getElementById('form_product').style.display = 'none';
            search_product_ajax(document.getElementById('search_product').value,page);
            invoices_table();
        });



        var page = 1;
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            search_product_ajax(document.getElementById('search_product').value,page);
            });

        $(function (){
            $(document).on("keypress", function() {
                $("#search_product").focus();
            });
        });
    </script>

<script>
    $(document).ready(function () {
    $('#tax_id1').on('change', function () {
        var selectedValue = $(this).val();

        // Clear the options in tax_id2
        $('#tax_id2').empty();

        // Add default option to tax_id2
        $('#tax_id2').append('<option value="">اختر قيمة الضريبة ...</option>');

        // Add formatted options to tax_id2 based on the selected value in tax_id
        @foreach ($taxes as $key)
            if ('{{ $key->id }}' !== selectedValue) {
                $('#tax_id2').append('<option value="{{ $key->id }}">{{ $key->tax_name }} ({{ $key->tax_ratio }}%)</option>');
            }
        @endforeach
    });
    });

    function alerttt(){

    }

    function if_checked() {
        var checkbox = document.getElementById("checkbox");
        var recurring_form = document.getElementById("recurring_form");

        if (checkbox.checked == true) {
            recurring_form.style.display = "block";
        } else {
            recurring_form.style.display = "none";
        }
    }
</script>

<script>
    $(function() {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>

@endsection
