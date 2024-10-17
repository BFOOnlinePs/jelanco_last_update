@extends('home')
@section('title')
    تقييم الطلب
@endsection
@section('header_title')
    تقييم الطلب
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
                                                    <td><input required type="radio" name="criteria[{{ $key->id }}]"
                                                            value="1">
                                                    </td>
                                                    <td><input required type="radio" name="criteria[{{ $key->id }}]"
                                                            value="2">
                                                    </td>
                                                    <td><input required type="radio" name="criteria[{{ $key->id }}]"
                                                            value="3">
                                                    </td>
                                                    <td><input required type="radio" name="criteria[{{ $key->id }}]"
                                                            value="4">
                                                    </td>
                                                    <td><input required type="radio" name="criteria[{{ $key->id }}]"
                                                            value="5">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">الملفات</label>
                                        @if (!empty($evaluation->file))
                                            <a type="text"
                                                href="{{ asset('storage/evaluation_file/' . $evaluation->file) }}"
                                                download="{{ $key->attachment }}" class="btn btn-primary btn-sm"><span
                                                    class="fa fa-download"></span></a>
                                            <button
                                                onclick="viewAttachment({{ $key->id }},'{{ asset('storage/evaluation_file/' . $evaluation->file) }}',null)"
                                                href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view_attachment" type="button"><span
                                                    class="fa fa-search"></span></button>
                                        @endif
                                        <input type="file" name="file" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">ملاحظات</label>
                                        <textarea name="notes" class="form-control" id="" cols="30" rows="3"></textarea>
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
                                                @if (auth()->user()->user_role == 1)
                                                    <div class="form-group">
                                                        <div
                                                            class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                            <input
                                                                onchange="update_evaluation_status_ajax({{ $evaluation->id }} , this.checked ? 'rated'
                                                    : 'not_rated' )"
                                                                type="checkbox"
                                                                @if ($evaluation->status == 'rated') checked @endif
                                                                class="custom-control-input"
                                                                id="customSwitch{{ $evaluation->id }}">
                                                            <label class="custom-control-label"
                                                                for="customSwitch{{ $evaluation->id }}">
                                                                حالة التقييم</label>
                                                        </div>
                                                    </div>
                                                @endif

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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">الملفات</label>
                                            @if (!empty($evaluation->file))
                                                <a type="text"
                                                    href="{{ asset('storage/evaluation_file/' . $evaluation->file) }}"
                                                    download="{{ $key->attachment }}"
                                                    class="btn btn-primary btn-sm"><span
                                                        class="fa fa-download"></span></a>
                                                <button
                                                    onclick="viewAttachment({{ $key->id }},'{{ asset('storage/evaluation_file/' . $evaluation->file) }}',null)"
                                                    href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                    data-target="#modal-lg-view_attachment" type="button"><span
                                                        class="fa fa-search"></span></button>
                                            @endif
                                            <input @if (
                                                $evaluation->status == 'rated' ||
                                                    (auth()->user()->role_id == 2 || auth()->user()->role_id == 9 || auth()->user()->role_id == 10)) disabled @endif type="file"
                                                name="file" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">ملاحظات</label>
                                            <textarea @if (
                                                $evaluation->status == 'rated' ||
                                                    (auth()->user()->role_id == 2 || auth()->user()->role_id == 9 || auth()->user()->role_id == 10)) disabled @endif
                                                onchange="update_notes_ajax({{ $evaluation->id }} , this.value)" name="notes" class="form-control"
                                                id="" cols="30" rows="3">{{ $evaluation->notes }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button @if (
                                            $evaluation->status == 'rated' ||
                                                (auth()->user()->role_id == 2 || auth()->user()->role_id == 9 || auth()->user()->role_id == 10)) disabled @endif type="submit"
                                            class="btn btn-success">حفظ التقييم</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            orders_list();
        });

        function orders_list() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('evaluation.orders_list') }}',
                method: 'post',
                headers: headers,
                data: {

                },
                success: function(data) {
                    $('#orders_list_table').html(data)
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }

            });
        }

        function update_evaluation_status_ajax(id, status) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('evaluation.update_evaluation_status_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'status': status
                },
                success: function(data) {
                    $('#orders_list_table').html(data)
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }

            });
        }

        function update_notes_ajax(id, value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('evaluation.update_notes_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'notes': value
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
