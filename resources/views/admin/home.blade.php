@extends('home')
@section('title')
    الرئيسية
@endsection
@section('header_title')
    لوحة التحكم
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    لوحة التحكم
@endsection
@section('content')
    <p class="text-muted mb-3">مرحباً {{ auth()->user()->name }}، هذه نظرة سريعة على آخر المستجدات.</p>

    <div class="row">
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('orders.procurement_officer.order_index') }}" class="jl-stat">
                <span class="jl-stat__icon" aria-hidden="true"><i class="fas fa-cart-shopping"></i></span>
                <span class="jl-stat__body">
                    <span class="jl-stat__value">{{ number_format($order_count) }}</span>
                    <span class="jl-stat__label">طلبية شراء</span>
                </span>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('product.home') }}" class="jl-stat">
                <span class="jl-stat__icon jl-stat__icon--success" aria-hidden="true"><i class="fas fa-boxes-stacked"></i></span>
                <span class="jl-stat__body">
                    <span class="jl-stat__value">{{ number_format($product_count) }}</span>
                    <span class="jl-stat__label">صنف</span>
                </span>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('users.supplier.index') }}" class="jl-stat">
                <span class="jl-stat__icon jl-stat__icon--warning" aria-hidden="true"><i class="fas fa-truck-field"></i></span>
                <span class="jl-stat__body">
                    <span class="jl-stat__value">{{ number_format($supplier_count) }}</span>
                    <span class="jl-stat__label">مورد</span>
                </span>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('tasks.index') }}" class="jl-stat">
                <span class="jl-stat__icon jl-stat__icon--danger" aria-hidden="true"><i class="fas fa-list-check"></i></span>
                <span class="jl-stat__body">
                    <span class="jl-stat__value">{{ number_format($task_count) }}</span>
                    <span class="jl-stat__label">مهمة</span>
                </span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header jl-card-head">
                    <h2 class="card-title">آخر الطلبيات</h2>
                    <a href="{{ route('orders.procurement_officer.order_index') }}" class="btn btn-outline-primary btn-sm">
                        عرض كل الطلبيات <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ر.مرجعي</th>
                                <th scope="col">الترسية</th>
                                <th scope="col">بواسطة</th>
                                <th scope="col">تاريخ الإرسال</th>
                                @if(auth()->user()->user_role != 3)
                                    <th scope="col" class="text-center"><span class="sr-only">العمليات</span></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($data as $key)
                                <tr>
                                    <td class="font-weight-bold">{{ $key->reference_number ?: '—' }}</td>
                                    <td>
                                        @foreach($key->supplier as $child)
                                            <span class="jl-chip jl-chip--muted mb-1">{{ optional($child['name'])->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ optional($key['user'])->name }}</td>
                                    <td class="text-nowrap">{{ $key->created_at }}</td>
                                    @if(auth()->user()->user_role != 3)
                                        <td class="text-center">
                                            <a href="{{ route('procurement_officer.orders.product.index',['order_id'=>$key->order_id]) }}"
                                               class="btn btn-light btn-sm" title="فتح الطلبية" aria-label="فتح الطلبية {{ $key->reference_number }}">
                                                <i class="fas fa-eye" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="jl-empty"><i class="fas fa-inbox" aria-hidden="true"></i>لا توجد طلبيات بعد</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header jl-card-head">
                    <h2 class="card-title">التقويم</h2>
                    <a href="{{ route('calendar.index') }}" class="btn btn-outline-primary btn-sm">
                        فتح التقويم <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    </a>
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
