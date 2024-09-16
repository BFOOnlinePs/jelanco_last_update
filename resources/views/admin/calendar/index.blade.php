@extends('home')
@section('title')
    التقويم
@endsection
@section('header_title')
    التقويم
@endsection
@section('header_link')
    طلبات الشراء
@endsection
@section('header_title_link')
    التقويم
@endsection
@section('style')

    <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

    <style>
        .overlay {
            position: relative;
        }

        #loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
        }

        .overlay-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
    <!-- Add these  lines at the end of the <body> section -->
@endsection
@section('content')

    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    {{--    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-default">اضافة طلبية شراء--}}
    {{--    </button>--}}
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">التقويم</h3>
        </div>

        <div class="card-body">
            <div id="calendar-ajax">
                <div id="calendar"></div>
            </div>
        </div>

        <div class="spinner-border" id="spinner" role="status">
            <span class="sr-only">Loading...</span>
        </div>


    </div>

    <div class="modal fade" id="modal-lg-calendar">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">اضافة ملاحظة</label>
                            <textarea class="form-control" name="note_text" id="note_text" cols="30" rows="4"
                                      placeholder="يرجى كتابة الملاحظة"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">اضافة ملف</label>
                            <input type="file" id="attachment_file" name="attachment_file" class="form-control">
                        </div>
                    </div>
                </div>
                <input type="hidden" id="start_date">
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button id="submit_button" type="button" class="btn btn-primary">حفظ</button>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="modal-lg-edit-calendar">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تعديل</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">اضافة ملاحظة</label>
                            <textarea class="form-control" name="note_text" id="edit_note_text" cols="30" rows="4"
                                      placeholder="يرجى كتابة الملاحظة"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">اضافة ملف</label>
                            <input type="file" id="edit_attachment_file" name="attachment_file" class="form-control">
                        </div>
                    </div>
                </div>
                <input type="hidden" id="start_date">

                <img src="" id="image" class="img-thumbnail m-2" style="width: 150px" alt="">
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button id="edit_button" type="button" class="btn btn-primary">تعديل</button>
                </div>
            </div>
            <div id="loading-overlay" class="overlay">
                <div class="overlay-content">
                    <div class="spinner"></div>
                </div>
            </div>
        </div>





    </div>
    <input type="hidden" id="event_id">
@endsection()

@section('script')

    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/fullcalendar/main.js') }}"></script>

    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>

    <script
        src='{{ asset('assets/calendar/js/cdn.jsdelivr.net_npm_fullcalendar@6.1.8_index.global.min.js') }}'></script>

    <script>
        $('#spinner').hide();
        function CalendarJs() {
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    themeSystem:'bootstrap',
                    eventClick:function (info) {
                        if(document.getElementById('event_id').value == ''){
                            document.getElementById('event_id').value = info.event.id;
                        }
                        $('#modal-lg-edit-calendar').modal();
                        document.getElementById('edit_note_text').value = info.event.title;
                        document.getElementById('image').src = '{{ asset('storage/attachment') }}' + '/' + info.event.extendedProps.attachment_file;

                        document.getElementById('edit_button').onclick = function () {
                            editEvent();
                            calendar.getEventById(info.event.id).setProp('title',document.getElementById('edit_note_text').value);

                            calendar.getEventById(info.event.id).setProp('attachment_file',document.getElementById('edit_attachment_file').value);
                        }
                    },
                    editable:false,
                    events:'{{ route('calendar.getEvents') }}',
                    eventResize(event,delta){
                        alert(event);
                    },
                    eventRender: function (event, element, view) {
                        if (event.allDay === 'true') {
                            event.allDay = true;
                        } else {
                            event.allDay = false;
                        }
                    },
                    selectable:true,
                    selectHelper: true,
                    dateClick:function (info){
                        const parsedDate = moment(info.date);
                        const formattedDate = info.dateStr.split('T')[0];
// Format the parsed date to display only the time component
                        const timeString = parsedDate.format("HH:mm:ss");
                        var newDate = '';
                        // if(info.view.type == 'dayGridMonth'){
                            newDate = formattedDate + ' ' + timeString;
                        // }
                        var modal = $('#modal-lg-calendar').modal();

                        document.getElementById('start_date').value = newDate;
                        document.getElementById('submit_button').onclick = function () {
                            createEvent();
                            calendar.addEvent({
                                id:document.getElementById('event_id').value,
                                start:document.getElementById('start_date').value,
                                title:document.getElementById('note_text').value,
                            });
                            calendar.unselect();
                        }
                    },

                    eventDrop:function (event, delta) {
                        const parsedDate = moment(event['event'].startStr);
                        const formattedDate = event['event'].startStr.split('T')[0];
                        const timeString = parsedDate.format("HH:mm:ss");
                        var newDate = '';
                        // if(info.view.type == 'dayGridMonth'){
                        newDate = formattedDate + ' ' + timeString;
                        console.log(event.event.start);
                            $.ajax({
                                url:"{{ route('calendar.updateEventDrop') }}",
                                type:"POST",
                                headers:{
                                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                                },
                                data:{
                                    id:event['event'].id,
                                    start:newDate
                                },
                                success:function(data)
                                {
                                    console.log(data);
                                    // calendar.refetchEvents();

                                    calendar.unselect();
                                    $('#modal-lg-calendar').modal('hide');

                                }
                            });
                    },

                    direction: 'rtl',
                });
                calendar.render();
            });

        }
        function createEvent(time){
            var note_text = document.getElementById('note_text').value;
            var start_date = document.getElementById('start_date').value;
            var attachment_file = $('#attachment_file')[0].files[0];

            var formData = new FormData();
            formData.append('start', start_date);
            formData.append('title', note_text);
            formData.append('attachment_file', attachment_file);
            formData.append('time', time);

            $.ajax({
                url: "{{ route('calendar.create') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData, // Use the FormData object
                contentType: false, // Important when sending files
                processData: false, // Important when sending files
                success: function(data) {
                    console.log(data);
                    document.getElementById('event_id').value = data.id;

                    $('#note_text').val('');
                    $('#attachment_file').val(''); // Clear the file input
                    $('#modal-lg-calendar').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function editEvent(){
            $('#loading-overlay').show();
            var note_text = document.getElementById('edit_note_text').value;
            var attachment_file = $('#edit_attachment_file')[0].files[0];

            var formData = new FormData();
            formData.append('id',document.getElementById('event_id').value);
            formData.append('title', note_text);
            formData.append('attachment_file', attachment_file);
            $.ajax({
                url:'{{ route('calendar.update') }}',
                type:"POST",
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                contentType: false, // Important when sending files
                processData: false, // Important when sending files
                data:formData,
                success:function(data)
                {
                    console.log(data);
                    $('#edit_note_text').val('');
                    $('#edit_attachment_file').val('');
                    // calendar.refetchEvents();
                    $('#modal-lg-edit-calendar').modal('hide');
                    $('#loading-overlay').hide();
                }
            });
        }

            window.onload = CalendarJs();
    </script>


    <script>


        // function showLoader() {
        //     $('#loaderContainer').show();
        // }
        //
        // // دالة لإخفاء شاشة التحميل
        // function hideLoader() {
        //     $('#loaderContainer').hide();
        // }
        //
        // function myFunction() {
        //     alert('load');
        // }

        // window.onload = getOrderTable();
    </script>

    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script>
        $(function () {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $('.swalDefaultSuccess').click(function () {
                Toast.fire({
                    icon: 'success',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultInfo').click(function () {
                Toast.fire({
                    icon: 'info',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultError').click(function () {
                Toast.fire({
                    icon: 'error',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultWarning').click(function () {
                Toast.fire({
                    icon: 'warning',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultQuestion').click(function () {
                Toast.fire({
                    icon: 'question',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });

            $('.toastrDefaultSuccess').click(function () {
                toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultInfo').click(function () {
                toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultError').click(function () {
                toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultWarning').click(function () {
                toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });

            $('.toastsDefaultDefault').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultTopLeft').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    position: 'topLeft',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultBottomRight').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    position: 'bottomRight',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultBottomLeft').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    position: 'bottomLeft',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultAutohide').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    autohide: true,
                    delay: 750,
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultNotFixed').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    fixed: false,
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultFull').click(function () {
                $(document).Toasts('create', {
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    icon: 'fas fa-envelope fa-lg',
                })
            });
            $('.toastsDefaultFullImage').click(function () {
                $(document).Toasts('create', {
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    image: '../../dist/img/user3-128x128.jpg',
                    imageAlt: 'User Picture',
                })
            });
            $('.toastsDefaultSuccess').click(function () {
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultInfo').click(function () {
                $(document).Toasts('create', {
                    class: 'bg-info',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultWarning').click(function () {
                $(document).Toasts('create', {
                    class: 'bg-warning',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultDanger').click(function () {
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultMaroon').click(function () {
                $(document).Toasts('create', {
                    class: 'bg-maroon',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
        });

    </script>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>

@endsection

