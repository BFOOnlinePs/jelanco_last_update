@extends('home')
@section('title')
    أمين المستودع
@endsection
@section('header_title')
    أمين المستودع
@endsection
@section('header_link')
    المستخدمين
@endsection
@section('header_title_link')
    أمين المستودع
@endsection
@section('content')

    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">

    <a href="{{ route('users.storekeeper.add') }}" class="btn btn-primary mb-2">اضافة أمين المستودع</a>
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">قائمة أمناء المستودعات</h3>
        </div>

        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
                               aria-describedby="example1_info">
                            <thead>
                            <tr>
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                    colspan="1" aria-sort="ascending">#
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">الاسم
                                </th>
                                <th>رقم الهاتف</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">البريد الالكتروني
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">حالة الحساب
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">العمليات
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key)
                                    <tr>
                                        <td>{{ $key->id }}</td>
                                        <td>{{ $key->name }}</td>
                                        <td style="direction: ltr !important;text-align:left;float:left">{{ $key->user_phone1 }}</td>
                                        <td>{{ $key->email }}</td>
                                        <td>
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                <input @if($key->user_status == 1) checked @endif onchange="updateStatus({{ $key->id }})" type="checkbox" class="custom-control-input" id="customSwitch{{$key->id}}">
                                                <label class="custom-control-label" for="customSwitch{{$key->id}}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="btn btn-success btn-sm" href="{{ route('users.storekeeper.edit',['id'=>$key->id]) }}"><span class="fa fa-edit"></span></a>
                                            <a class="btn btn-dark btn-sm" href="{{ route('users.storekeeper.details',['id'=>$key->id]) }}"><span class="fa fa-search"></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection()

    @section('script')
        <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>


{{--        <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>--}}

        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

        <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

        <script src="{{ asset('assets/dist/js/demo.js') }}"></script>

        <script>
            function updateStatus(id){
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url:'{{ url('users/updateStatus') }}',
                    method:'post',
                    headers:headers,
                    data:{
                        'id':id,
                        'user_status': document.getElementById('customSwitch'+id).checked
                    },
                    success: function(data) {
                        toastr.success('تم تعديل الحالة بنجاح')
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            }
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
            $(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                $('.swalDefaultSuccess').click(function() {
                    Toast.fire({
                        icon: 'success',
                        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
                $('.swalDefaultInfo').click(function() {
                    Toast.fire({
                        icon: 'info',
                        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
                $('.swalDefaultError').click(function() {
                    Toast.fire({
                        icon: 'error',
                        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
                $('.swalDefaultWarning').click(function() {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
                $('.swalDefaultQuestion').click(function() {
                    Toast.fire({
                        icon: 'question',
                        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });

                $('.toastrDefaultSuccess').click(function() {
                    toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
                });
                $('.toastrDefaultInfo').click(function() {
                    toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
                });
                $('.toastrDefaultError').click(function() {
                    toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
                });
                $('.toastrDefaultWarning').click(function() {
                    toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
                });

                $('.toastsDefaultDefault').click(function() {
                    $(document).Toasts('create', {
                        title: 'Toast Title',
                        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
                $('.toastsDefaultTopLeft').click(function() {
                    $(document).Toasts('create', {
                        title: 'Toast Title',
                        position: 'topLeft',
                        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
                $('.toastsDefaultBottomRight').click(function() {
                    $(document).Toasts('create', {
                        title: 'Toast Title',
                        position: 'bottomRight',
                        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
                $('.toastsDefaultBottomLeft').click(function() {
                    $(document).Toasts('create', {
                        title: 'Toast Title',
                        position: 'bottomLeft',
                        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
                $('.toastsDefaultAutohide').click(function() {
                    $(document).Toasts('create', {
                        title: 'Toast Title',
                        autohide: true,
                        delay: 750,
                        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
                $('.toastsDefaultNotFixed').click(function() {
                    $(document).Toasts('create', {
                        title: 'Toast Title',
                        fixed: false,
                        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
                $('.toastsDefaultFull').click(function() {
                    $(document).Toasts('create', {
                        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
                        title: 'Toast Title',
                        subtitle: 'Subtitle',
                        icon: 'fas fa-envelope fa-lg',
                    })
                });
                $('.toastsDefaultFullImage').click(function() {
                    $(document).Toasts('create', {
                        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
                        title: 'Toast Title',
                        subtitle: 'Subtitle',
                        image: '../../dist/img/user3-128x128.jpg',
                        imageAlt: 'User Picture',
                    })
                });
                $('.toastsDefaultSuccess').click(function() {
                    $(document).Toasts('create', {
                        class: 'bg-success',
                        title: 'Toast Title',
                        subtitle: 'Subtitle',
                        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
                $('.toastsDefaultInfo').click(function() {
                    $(document).Toasts('create', {
                        class: 'bg-info',
                        title: 'Toast Title',
                        subtitle: 'Subtitle',
                        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
                $('.toastsDefaultWarning').click(function() {
                    $(document).Toasts('create', {
                        class: 'bg-warning',
                        title: 'Toast Title',
                        subtitle: 'Subtitle',
                        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
                $('.toastsDefaultDanger').click(function() {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Toast Title',
                        subtitle: 'Subtitle',
                        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
                $('.toastsDefaultMaroon').click(function() {
                    $(document).Toasts('create', {
                        class: 'bg-maroon',
                        title: 'Toast Title',
                        subtitle: 'Subtitle',
                        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    })
                });
            });

        </script>

    @endsection

