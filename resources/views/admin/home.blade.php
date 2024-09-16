@extends('home')
@section('title')
    الرئيسية
@endsection
@section('header_title')
    الرئيسية
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    الرئيسية
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">

            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $order_count }}</h3>
                    <p>الطلبيات</p>
                </div>
                <div class="icon">
                    <i class="fa fa-bag-shopping"></i>
                </div>
                <a href="{{ route('orders.procurement_officer.order_index') }}" class="small-box-footer">المزيد <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">

            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $product_count }}</h3>
                    <p>الاصناف</p>
                </div>
                <div class="icon">
                    <i class="fa fa-list"></i>
                </div>
                <a href="{{ route('product.home') }}" class="small-box-footer">المزيد <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">

            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $supplier_count }}</h3>
                    <p>الموردين</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="{{ route('users.supplier.index') }}" class="small-box-footer">المزيد <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">

            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $task_count }}</h3>
                    <p>مهمة</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tasks"></i>
                </div>
                <a href="{{ route('tasks.index') }}" class="small-box-footer">المزيد <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="">اخر الطلبيات</span>
                    <a href="{{ route('orders.procurement_officer.order_index') }}" class="btn btn-dark btn-sm" style="float: left">عرض الطلبيات</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table id="example1"  class="table table-bordered table-hover text-center dataTable dtr-inline"
                                   aria-describedby="example1_info">
                                <thead class="bg-dark">
                                <tr>
                                    {{--                <th>رقم طلبية الشراء</th>--}}
                                    <th>ر.مرجعي</th>
                                    <th width="150">الترسية</th>
                                    <th>بواسطة</th>
                                    <th>تاريخ الارسال</th>
                                    @if(!auth()->user()->user_role == 3)
                                    <th>العمليات</th>
                                    @endif
                                    {{--                    <th>العمليات</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $key)
                                    <tr class="">
                                        {{--                    <td>{{ $key->id }}</td>--}}
                                        {{--                    <td>{{ $key->order_id }}</td>--}}
                                        <td>{{ $key->reference_number }}
                                        {{--                            <span onclick="getReferenceNumber({{ $key->order_id }})" class="fa fa-edit text-success" style="float: left" data-toggle="modals" data-target="#modals-reference_number"></span></td>--}}
                                        <td>
                                            @foreach($key->supplier as $child)
                                                {{ $child['name']->name }},
                                            @endforeach
                                        </td>
                                        <td>{{ $key['user']->name }}</td>
                                        <td>{{ $key->created_at }}</td>
                                        @if(!auth()->user()->user_role == 3)
                                        <td>
                                            <a href="{{ route('procurement_officer.orders.product.index',['order_id'=>$key->order_id]) }}" class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>
                                        </td>
                                        @endif
                                        {{--                        <td>--}}
                                        {{--                                                        <a href="{{ route('procurement_officer.orders.product.index',['order_id'=>$key->order_id]) }}"--}}
                                        {{--                                                           class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>--}}
                                        {{--                                                    <button type="button" onclick="getReferenceNumber({{ $key->order_id }})" class="btn btn-success btn-sm" data-toggle="modals" data-target="#modals-reference_number">--}}
                                        {{--                                                        تعديل الرقم المرجعي--}}
                                        {{--                                                    </button>--}}
                                        {{--                                                        <a href="{{ route('orders.procurement_officer.delete_order',['id'=>$key->order_id]) }}" onclick="return confirm('هل انت متاكد من عملية الحذف علما انه بعد الحذف سوف يتم نقله لسلة المحذوفات')" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>--}}
                                        {{--                        </td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{--    <div class="col-lg-3 col-6">--}}

                    {{--        <div class="small-box bg-danger">--}}
                    {{--            <div class="inner">--}}
                    {{--                <h3>65</h3>--}}
                    {{--                <p>Unique Visitors</p>--}}
                    {{--            </div>--}}
                    {{--            <div class="icon">--}}
                    {{--                <i class="ion ion-pie-graph"></i>--}}
                    {{--            </div>--}}
                    {{--            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
                    {{--        </div>--}}
                    {{--    </div>--}}

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="text-center">التقويم</span>
                    <a href="{{ route('calendar.index') }}" class="btn btn-dark btn-sm" style="float: left">عرض التقويم</a>
                </div>

                <div class="card-body">
                    <div id="calendar-ajax">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection()
@section('script')
    <script
        src='{{ asset('assets/calendar/js/cdn.jsdelivr.net_npm_fullcalendar@6.1.8_index.global.min.js') }}'></script>
    <script>

        function CalendarJs() {
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headers: {
                        center: 'title'
                    },
                    editable: false,
                    events: '{{ route('calendar.getEvents') }}',
                    eventResize(event, delta) {
                        alert(event);
                    },
                    eventRender: function (event, element, view) {
                        if (event.allDay === 'true') {
                            event.allDay = true;
                        } else {
                            event.allDay = false;
                        }
                    },
                    selectable: true,
                    selectHelper: true,
                    select: function (start, end, allDay, startStr) {
                        var modal = $('#modals-lg-calendar').modal();
                        var submit_button = document.getElementById('submit_button');
                        submit_button.addEventListener("click", function () {
                            $.ajax({
                                url: "{{ route('procurement_officer.orders.calender.create') }}",
                                type: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    start: start['startStr'],
                                },
                                success: function (data) {
                                    console.log(data);
                                    // calendar.refetchEvents();
                                    calendar.addEvent({
                                        id: data.id,
                                        start: data['start'],
                                    });

                                    calendar.unselect();
                                    $('#modals-lg-calendar').modal('hide');

                                }
                            });
                        });

                    },
                    // events: [
                    //     {
                    //         title: 'event1',
                    //         start: '2023-08-14',
                    //     },
                    //     {
                    //         title: 'event2',
                    //         start: '2023-08-12',
                    //         end: '2023-08-18',
                    //     },
                    //     {
                    //         title: 'event3',
                    //         start: '2023-08-14T12:30:00',
                    //         allDay: false // will make the time show
                    //     }
                    // ],


                    {{--select:function (start, end, allDay,startStr){--}}
                        {{--    var modals = $('#modals-lg-calendar').modals();--}}
                        {{--    var submit_button = document.getElementById('submit_button');--}}
                        {{--    submit_button.addEventListener("click", function() {--}}
                        {{--        $.ajax({--}}
                        {{--            url:"{{ route('procurement_officer.orders.calender.create') }}",--}}
                        {{--            type:"POST",--}}
                        {{--            headers:{--}}
                        {{--                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')--}}
                        {{--            },--}}
                        {{--            data:{--}}
                        {{--                notification_time: start['startStr'],--}}
                        {{--            },--}}
                        {{--            success:function(data)--}}
                        {{--            {--}}
                        {{--                console.log(data);--}}
                        {{--                calendar.refetchEvents();--}}
                        {{--                $('#modals-lg-calendar').modals('hide');--}}
                        {{--            }--}}
                        {{--        })--}}
                        {{--    });--}}
                        {{--},--}}

                    direction: 'rtl',
                    dateClick: function (info) {
                        // The info parameter contains information about the clicked day
                        var clickedDate = info;
                        // console.log(info);
                        // $('#modals-lg-calendar').modals();
                        // Perform your custom action here
                    }
                });
                calendar.render();
            });

        }

        {{--function getCalendar() {--}}
            {{--    var csrfToken = $('meta[name="csrf-token"]').attr('content');--}}
            {{--    var headers = {--}}
            {{--        "X-CSRF-Token": csrfToken--}}
            {{--    };--}}
            {{--    $.ajax({--}}
            {{--        url: '{{ url('users/procurement_officer/orders/calender/calendar_ajax') }}',--}}
            {{--        method: 'get',--}}
            {{--        headers: headers,--}}
            {{--        success: function (data) {--}}
            {{--            $('#calendar-ajax').html(data);--}}
            {{--            // calendarJS();--}}
            {{--        },--}}
            {{--        error: function (jqXHR, textStatus, errorThrown) {--}}
            {{--            alert('error');--}}
            {{--        }--}}
            {{--    });--}}
            {{--}--}}

            window.onload = CalendarJs();
    </script>

@endsection
