@extends('home')
@section('title')
    ارسال رسالة
@endsection
@section('header_title')
    ارسال رسالة
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    ارسال رسالة
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <style>
        div.scroll {
            height: 400px;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 20px;
        }
    </style>
@endsection
@section('content')

    <input type="hidden" id="received_id">
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="row">
{{--                <div class="col-md-12">--}}
{{--                    <buttn class="btn btn-dark">صفحة الرسائل الواردة</buttn>--}}
{{--                    <buttn class="btn btn-dark">صفحة الرسائل المرسلة</buttn>--}}
{{--                </div>--}}
                <div class="col-md-12 mt-2">
                    <div class="card">
                        <div class="card-body row">
                            <form class="col-md-12" action="{{ route('message.send_message') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-3 text-center">
                                        <input id="search_input" onkeyup="list_users_ajax()" type="text" class="form-control" style="font-size: 14px" placeholder="بحث عن مستخدم">
                                        <div style="width:100%" id="list_users_ajax" class="">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="scroll" id="list_message">

                                        </div>
                                        <input style="display: none" id="text_message" type="text" class="form-control mt-2" placeholder="نص الرسالة">
                                    </div>
                                    <div class="col">
                                        <div class="row text-center">
                                            <div class="col-md-12">
                                                <h6 class="">طلبيات الشراء</h6>
                                                <input onkeyup="orders_table_ajax()" id="order_search" class="form-control text-center" type="text" placeholder="بحث عن الرقم المرجعي">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <div id="order_table">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('admin.message.modals.select_tag_fro_order_modal')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>

        $(document).ready(function(){
            list_users_ajax();
            // orders_table_ajax();
            list_orders_for_tag();
        })


        function saveScrollPosition() {
            var scrollDiv = document.getElementById('list_message');
            if (scrollDiv) {
                scrollPosition = scrollDiv.scrollTop;
            }
        }

        // Function to restore scroll position
        function restoreScrollPosition() {
            var scrollDiv = document.getElementById('list_message');
            if (scrollDiv) {
                scrollDiv.scrollTop = scrollPosition;
            }
        }

        $(document).ready(function() {
            $('#list_message').on('scroll', function() {
                console.log(scrollPosition);
                saveScrollPosition();
            });
        });

        function list_users_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('list_users_ajax').innerHTML = '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '{{ route('message.list_users_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'search_input':$('#search_input').val()
                },
                success: function(data) {
                    $('#list_users_ajax').html(data.view)
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }

            });
        }


        // Attach scroll event listener to save scroll position
        setInterval(function() {
            var received_id = $('#received_id').val();
            if(received_id) {
                list_message_ajax(received_id);
            }
        }, 3000);
        var scrollDiv = document.getElementById('list_message');

        var scrollPosition = scrollDiv.scrollHeight * 10;

        function click_button_to_show_message_and_order(id){
            $('#received_id').val(id);
            orders_table_ajax();
            list_message_ajax(id);
        }

        function list_message_ajax(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            // scrollPosition = scrollDiv.scrollTop;

                $.ajax({
                    url: '{{ route('message.list_message_ajax') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'reciver': id
                    },
                    success: function(data) {
                        if (data.success === 'true') {
                            $('#list_message').html(data.view);
                            $('#text_message').css('display', 'inline');

                            // Restore scroll position after updating
                            scrollDiv.scrollTop = scrollPosition;

                            on_select_user = true;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });

        }

        function orders_table_ajax() {
            // $('#received_id').val(id);
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('order_table').innerHTML = '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '{{ route('message.orders_table_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_search':$('#order_search').val(),
                    'reciver':$('#received_id').val(),
                },
                success: function(data) {
                    if(data.success === 'true'){
                        $('#order_table').html(data.view);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }

            });
        }

        function list_orders_for_tag() {
            // $('#received_id').val(id);
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('orders_table_for_tag').innerHTML = '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '{{ route('message.list_orders_for_tag') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_search_for_tag':$('#order_search_for_tag').val(),
                },
                success: function(data) {
                    if(data.success === 'true'){
                        $('#orders_table_for_tag').html(data.view);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }

            });
        }

        function cache_clear() {
            list_message_ajax($('#received_id').val());
        }

        function create_message_ajax(text) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            if ($('#text_message').val() != ''){
                $.ajax({
                    url: '{{ route('message.create_message_ajax') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'reciver':$('#received_id').val(),
                        'message':text,
                    },
                    success: function(data) {
                        if(data.success === 'true'){
                            list_message_ajax($('#received_id').val());
                            $('#text_message').val('');
                            scrollDiv.scrollTop = scrollDiv.scrollHeight * 10;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
            // document.getElementById('list_message').innerHTML = '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
        }

        $('#text_message').keypress(function(e){
            if(e.which == 13){
                create_message_ajax($(this).val());
            }
        });

        function create_tag_for_message(data) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            // document.getElementById('list_message').innerHTML = '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '{{ route('message.create_tag_for_message') }}',
                method: 'post',
                headers: headers,
                data: {
                    'chat_message_id':$('#chat_message_id').val(),
                    'order_tag':data.id
                },
                success: function(data) {
                    if(data.success === 'true'){
                        $('#select_tag_fro_order_modal').modal('hide');
                        list_message_ajax($('#received_id').val());
                        orders_table_ajax();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function delete_message_tag(chat_id) {
            var confiirm_message = confirm('هل تريد حذف التاغ للطلبية في المحادثة الحالية ؟');
            if (!confiirm_message){
                return ;
            }
            else {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                // document.getElementById('list_message').innerHTML = '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
                $.ajax({
                    url: '{{ route('message.delete_message_tag') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'id':chat_id,
                    },
                    success: function(data) {
                        if(data.success === 'true'){
                            $('#select_tag_fro_order_modal').modal('hide');
                            list_message_ajax($('#received_id').val());
                            orders_table_ajax();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        }

        function open_modal_for_order_tag(data){
            $('#chat_message_id').val(data.id);
            $('#select_tag_fro_order_modal').modal('show')
        }
    </script>

    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection
