@extends('home')
@section('title')
    ملاحظاتي
@endsection
@section('header_title')
    ملاحظاتي
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    ملاحظاتي
@endsection
@section('style')
{{--    <style>--}}
{{--        * {--}}
{{--            -webkit-box-sizing:border-box;--}}
{{--            -moz-box-sizing:border-box;--}}
{{--            -ms-box-sizing:border-box;--}}
{{--            -o-box-sizing:border-box;--}}
{{--            box-sizing:border-box;--}}
{{--            direction:rtl;--}}
{{--        }--}}

{{--        body {--}}
{{--            background: #f1f1f1;--}}
{{--            font-family:helvetica neue, helvetica, arial, sans-serif;--}}
{{--            font-weight:200;--}}
{{--        }--}}

{{--        .notebook-paper {--}}
{{--            background: linear-gradient(to bottom,white 29px,#00b0d7 1px);--}}
{{--            margin:50px auto;--}}
{{--            background-size: 100% 30px;--}}
{{--            position:relative;--}}
{{--            padding-top:150px;--}}
{{--            padding-right:160px;--}}
{{--            padding-left:20px;--}}
{{--            overflow:hidden;--}}
{{--            border-radius:5px;--}}
{{--            -webkit-box-shadow:3px 3px 3px rgba(0,0,0,.2),0px 0px 6px rgba(0,0,0,.2);--}}
{{--            -moz-box-shadow:3px 3px 3px rgba(0,0,0,.2),0px 0px 6px rgba(0,0,0,.2);--}}
{{--            -ms-box-shadow:3px 3px 3px rgba(0,0,0,.2),0px 0px 6px rgba(0,0,0,.2);--}}
{{--            -o-box-shadow:3px 3px 3px rgba(0,0,0,.2),0px 0px 6px rgba(0,0,0,.2);--}}
{{--            box-shadow:3px 3px 3px rgba(0,0,0,.2),0px 0px 6px rgba(0,0,0,.2);--}}
{{--            &:before {--}}
{{--                content:'';--}}
{{--                display:block;--}}
{{--                position:absolute;--}}
{{--                z-index:1;--}}
{{--                top:0;--}}
{{--                right:140px;--}}
{{--                height:100%;--}}
{{--                width:1px;--}}
{{--                background:#db4034;--}}
{{--            }--}}
{{--            header {--}}
{{--                height:150px;--}}
{{--                width:100%;--}}
{{--                background:white;--}}
{{--                position:absolute;--}}
{{--                top:0;--}}
{{--                right:0;--}}
{{--                h1 {--}}
{{--                    font-size:22px;--}}
{{--                    font-weight: bold;--}}
{{--                    line-height:60px;--}}
{{--                    padding:127px 160px 0 20px;--}}
{{--                }--}}
{{--            }--}}
{{--            .content {--}}
{{--                margin-top:67px;--}}
{{--                font-size:20px;--}}
{{--                line-height:30px;--}}
{{--                p {--}}
{{--                    margin:0 0 30px 0;--}}
{{--                }--}}
{{--            }--}}
{{--        }--}}
{{--    </style>--}}
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-dark mb-2" data-toggle="modal" data-target="#add_currency_modal">اضافة ملاحظة
            </button>
            <a href="{{ route('note_book.index') }}" class="btn btn-dark mb-2">الملاحظات
            </a>
            <a href="{{ route('note_book.archive_note_book_index') }}" class="btn btn-dark mb-2">ارشيف الملاحظات
            </a>
            <a href="{{ route('note_book.note_book_pdf') }}" class="btn float-right btn-warning mb-2"><span class="fa fa-print"></span>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">اسم الموظف</label>
                                    <select class="form-control select2bs4" name="" onchange="note_book_table_ajax()" id="user_select_id">
                                        <option value="">جميع الموظفين ...</option>
                                        @foreach($users as $key)
                                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">حالة الملاحظة</label>
                                <select class="form-control" name="" onchange="note_book_table_ajax()" id="status_note">
                                    <option value="">جميع الحالات ...</option>
                                    <option value="new">جديدة</option>
                                    <option value="in_progress">قيد المعالجة</option>
                                    <option value="done">انتهت</option>
                                    <option value="deleted">محذوفة</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">من تاريخ</label>
                                <input type="date" onchange="note_book_table_ajax()" id="from_date" value="{!! date('Y-01-01') !!}" placeholder="من تاريخ" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">الى تاريخ</label>
                                <input type="date" onchange="note_book_table_ajax()" id="to_date" value="{!! \Carbon\Carbon::now()->addDay(1)->toDateString() !!}" placeholder="الى تاريخ" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row" id="note_book_table_ajax">

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.note_book.modals.add_note_book_modal')
    @include('admin.note_book.modals.edit_note_book_modal')
@endsection()
@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            note_book_table_ajax();

            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
        function updateStatus(id,value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('note_book.update_status') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'value': value
                },
                success: function (data) {
                    note_book_table_ajax();
                    // if (value === 'deleted')
                    // {
                    //     $('#tr_status_'+id).addClass('bg-danger');
                    // }
                    // else{
                    //     $('#tr_status_'+id).removeClass('bg-danger');
                    // }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
        function note_book_table_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('note_book.note_book_table_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    user_id: $('#user_select_id').val(),
                    status: $('#status_note').val(),
                    from_date: $('#from_date').val(),
                    to_date: $('#to_date').val(),
                },
                success: function (data) {
                    $('#note_book_table_ajax').html(data.view);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
        function edit_note_book_modal(data) {
            $('#edit_note_book_modal').modal('show');
            $('#note_text').val(data.note_text);
            $('#note_description').val(data.note_description);
            $('#edit_note_book_id').val(data.id);
        }
        $('#edit_note_book_form').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                headers: headers,
                dataType:'json',
                data: {
                    'id': formData.get('edit_note_book_id'),
                    'note_text': formData.get('note_text'),
                    'note_description': formData.get('note_description'),
                },
                success: function (data) {
                    $('#edit_note_book_modal').modal('hide');
                    note_book_table_ajax();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        })
    </script>
@endsection

