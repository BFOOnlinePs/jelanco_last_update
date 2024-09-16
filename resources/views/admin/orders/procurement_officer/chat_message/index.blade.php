@extends('home')
@section('title')
    محادثات
@endsection
@section('header_title')
    <span>محادثات <span>@if($order->reference_number != 0)
                #{{ $order->reference_number }}
            @endif</span></span>
@endsection
@section('header_link')
    طلبات الشراء
@endsection
@section('header_title_link')
    مرفقات
@endsection
@section('style')

@endsection
@section('content')
    {{--    @include('admin.orders.progreesbar')--}}
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    @include('admin.orders.order_menu')
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">المحادثات</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>المرسل</th>
                                    <th>المستقبل</th>
                                    <th>نص الرسالة</th>
                                    <th>تاريخ الارسال</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">لا توجد محادثات</td>
                                    </tr>
                                @else
                                    @foreach($data as $key)
                                        <tr>
                                            <td>{{ $key->user_sender->name }}</td>
                                            <td>{{ $key->user_reciver->name }}</td>
                                            <td>{{ $key->message }}</td>
                                            <td>{{ $key->insert_at }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <p>تم انشاء هذه الطلبية بواسطة <span class="text-danger text-bold">{{ $order['user']->name ?? '' }}</span> ويتم متابعتها بواسطة <span class="text-danger text-bold">{{ $order['to_user']->name ?? '' }}</span></p>
    </div>
@endsection()

@section('script')
    <script>
        function updateStatus(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ url('users/updateStatus') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'user_status': document.getElementById('customSwitch' + id).checked
                },
                success: function (data) {
                    toastr.success('تم تعديل الحالة بنجاح')
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
    </script>

@endsection

