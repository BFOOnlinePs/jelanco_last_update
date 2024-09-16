<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>@yield('title')</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    {{--    <link rel="stylesheet" href="{{ asset('assets/fonts/Tajawal/SansPro.min.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap_rtl-v4.2.1/bootstrap.min.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap_rtl-v4.2.1/custom_rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/mycustomstyle.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/jquery-ui/jquery-ui.css') }}">
    @yield('style')
    <style>
        * {
            font-family: 'Tajawal', sans-serif;
        }

        #calendar {
            direction: ltr !important;
        }

        .pagination > li > a,
        .pagination > li > span {
            color: black; // use your own color here
        }

        .pagination > .active ,
        .pagination > .active > a,
        .pagination > .active > a:focus,
        .pagination > .active > a:hover,
        .pagination > .active > span,
        .pagination > .active > span:focus,
        .pagination > .active > span:hover {
            background-color: black;
            border-color: black;
        }

        .page-item.active .page-link {
            background-color: black;
            border-color: black;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    @include('layouts.navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('layouts.sidebar')
    <!-- Content Wrapper. Contains page content -->
    @include('layouts.content')

    <div class="modal fade" id="modal-lg-view_attachment">
        <input type="hidden" id="viewAttachmentWithId">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <iframe id="view_attachment_result" src="" frameborder="0" width="100%" style="height: 550px">

                    </iframe>
                </div>
                <div class=" justify-content-between">
                    <div class="row p-3 mb-2">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                            <a type="button" id="download-attachment" class="btn btn-primary">تحميل</a>
                        </div>
                        <div style="display: none" id="note_form" class="col-md-9">
                            <div>
                                <textarea class="form-control" name="" id="note_input" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

<script src="{{ asset('assets/jquery-ui/jquery-ui.js') }}"></script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $(function() {
        // Select all input elements with type="date" and apply Datepicker
        $('.date_format').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>
</script>

@yield('script')

<script>
    function viewAttachment(id,url,notes) {
        document.getElementById('viewAttachmentWithId').value = id;
        document.getElementById('view_attachment_result').src = url;
        document.getElementById('download-attachment').href = url;
        document.getElementById('download-attachment').download = 'attachment_'+id;
        if(notes != null){
            document.getElementById('note_form').style.display = 'inline';
            document.getElementById('note_input').value = notes;
        }
    }

    function notes_edit_for_view_attachment(id,notes) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var headers = {
            "X-CSRF-Token": csrfToken
        };
        $.ajax({
            url: '{{ route('global.update_notes_for_view_attachment_modal_ajax') }}',
            method: 'post',
            headers: headers,
            data: {
                'id':id,
                'notes' : notes,
            },
            success: function(data) {
                if(data.success == 'true'){
                    toastr.success(data.message)
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }

        });
    }
    function viewAttachmentWithId(id) {
        document.getElementById('viewAttachmentWithId').value = id;
    }
    $(document).ready(function() {
        $('#note_input').on('change', function() {
            var notes = $('#note_input').val();
            var id = $('#viewAttachmentWithId').val();
            notes_edit_for_view_attachment(id, notes);
        });
    });


    // function formatAllDateInputs() {
    //     alert('asd');
    //     const dateInputs = document.querySelectorAll('input[type="date"]');
    //     dateInputs.forEach(input => {
    //         const inputValue = input.value;
    //         const datePattern = /^\d{4}-\d{2}-\d{2}$/; // Default format for type="date"
    //         if (datePattern.test(inputValue)) {
    //             const formattedValue = inputValue.split('-').reverse().join('/');
    //             input.value = formattedValue;
    //         }
    //     });
    // }
    //
    // document.addEventListener('DOMContentLoaded', function () {
    //     formatAllDateInputs();
    // });

    // Use datepicker on the date inputs


</script>
</body>
</html>
