@extends('home')
@section('title')
    تقييم الطلبات
@endsection
@section('header_title')
    تقييم الطلبات
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    تقييم الطلبات
@endsection
@section('style')
@endsection
@section('content')
    <div class="card bg-gradient-info">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">رقم المرجع</label>
                        <input onkeyup="orders_list()" placeholder="رقم المرجع" id="reference_number" name="reference_number"
                            class="form-control" type="text">
                    </div>
                </div>
                {{-- <div class="col-md-3">
                    <div class="form-group">
                        <label for="">المورد</label>
                        <select onchange="getOrderTable()" class="select2bs4 form-control supplier_select2"
                            name="supplier_id" id="supplier_id">
                            <option value="">جميع الموردين</option>
                            @foreach ($supplier as $key)
                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
                {{-- <div class="col-md-3">
                    <div class="form-group">
                        <label for="">متابعة بواسطة</label>
                        <select onchange="getOrderTable()" class="select2bs4 form-control supplier_select2" name="to_user"
                            id="to_user">
                            <option value="">جميع المستخدمين</option>
                            @foreach ($users as $key)
                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
                {{-- <div class="col-md-3">
                    <div class="form-group">
                        <label for="">مجال العمل</label>
                        <select onchange="getOrderTable()" class="select2bs4 form-control supplier_select2"
                            name="user_category" id="user_category">
                            <option value="">جميع مجالات العمل</option>
                            @foreach ($user_category as $key)
                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
                {{-- <div class="col-md-3">
                    <div class="form-group">
                        <label for="">حالة الطلبية</label>
                        <select onchange="getOrderTable()" class="form-control" name="order_status" id="order_status">
                            <option value="">جميع الحالات</option>
                            @foreach ($order_status as $key)
                                @if ($key->id != 10)
                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div> --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">من تاريخ</label>
                        {{-- <input onchange="getOrderTable()" name="from" id="from" value="<?php echo date('Y-01-01'); ?>" type="text" class="form-control date_format"> --}}
                        <input onchange="orders_list()" name="from" id="from" value="<?php echo '2023-01-01'; ?>"
                            type="text" class="form-control date_format">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">الى تاريخ</label>
                        <input onchange="orders_list()" name="to" id="to" value="<?php echo date('Y-m-d'); ?>"
                            type="text" class="form-control date_format">
                    </div>
                </div>
                <div class="col-md-3">
                    {{--                    <div class="form-group"> --}}
                    {{--                        <label for="">هل هذا المورد معتمد ؟ :</label> --}}
                    {{--                        <br> --}}
                    {{--                        <div onchange="getOrderTable('')" style="display: inline" class="custom-control custom-radio"> --}}
                    {{--                            <input class="custom-control-input" type="radio" value="certified" id="customRadio1" name="customRadio" checked=""> --}}
                    {{--                            <label for="customRadio1" class="custom-control-label">نعم</label> --}}
                    {{--                        </div> --}}
                    {{--                        <div onchange="getOrderTable('')" style="display: inline" class="custom-control custom-radio"> --}}
                    {{--                            <input class="custom-control-input" value="not_supported" type="radio" id="customRadio2" name="customRadio"> --}}
                    {{--                            <label for="customRadio2" class="custom-control-label">لا</label> --}}
                    {{--                        </div> --}}
                    {{--                    </div> --}}
                    {{-- <div class="form-group">
                        <label for="">مورد معتمد</label>
                        <select onchange="orders_list()" class="form-control select2bs4" name="" id="supplier_type">
                            <option value="">جميع الموردين</option>
                            <option value="certified">مورد معتمد</option>
                            <option value="not_supported">مورد غير معتمد</option>
                        </select>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" id="orders_list_table">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            orders_list();
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];

            orders_list(page);
        });

        function orders_list(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('evaluation.orders_list') }}',
                method: 'post',
                headers: headers,
                data: {
                    'page': page,
                    'reference_number': $('#reference_number').val(),
                    'supplier_type': $('#supplier_type').val(),
                    'from': $('#from').val(),
                    'to': $('#to').val(),
                    'order_status': $('#order_status').val(),
                    'user_category': $('#user_category').val(),
                },
                success: function(data) {
                    $('#orders_list_table').html(data)
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }

            });
        }
    </script>
@endsection
