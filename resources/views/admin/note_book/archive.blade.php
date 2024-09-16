@extends('home')
@section('title')
    ارشيف الملاحظات
@endsection
@section('header_title')
    ارشيف الملاحظات
@endsection
@section('header_link')
    دفتر الملاحظات
@endsection
@section('header_title_link')
    ارشيف الملاحظات
@endsection
@section('style')
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="archive_note_book_table">

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.note_book.modals.add_note_book_modal')
    @include('admin.note_book.modals.edit_note_book_modal')
@endsection()
@section('script')
    <script>
        $(document).ready(function () {
            archive_note_book_table_ajax();
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
                    archive_note_book_table_ajax()
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
        function archive_note_book_table_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('note_book.archive_note_book_table_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    status: $('#status_note').val(),
                    from_date: $('#from_date').val(),
                    to_date: $('#to_date').val(),
                },
                success: function (data) {
                    $('#archive_note_book_table').html(data.view);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
    </script>
@endsection

