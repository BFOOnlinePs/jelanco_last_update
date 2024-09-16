@extends('home')
@section('title')
    شركات النقل المحلي
@endsection
@section('header_title')
    شركات النقل المحلي
@endsection
@section('header_link')
    المستخدمين
@endsection
@section('header_title_link')
    شركات النقل المحلي
@endsection
@section('content')

    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <a href="{{ route('users.local_carriers.add') }}" class="btn btn-primary mb-2">اضافة شركة نقل محلي</a>
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">قائمة شركات النقل المحلي</h3>
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
                                            @if($key->user_status == 1)
                                                <span class="text-success">فعال</span>
                                            @elseif($key->user_status == 0)
                                                <span class="text-danger">غير فعال</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-success btn-sm" href="{{ route('users.local_carriers.edit',['id'=>$key->id]) }}"><span class="fa fa-edit"></span></a>
                                            <a class="btn btn-dark btn-sm" href="{{ route('users.local_carriers.details',['id'=>$key->id]) }}"><span class="fa fa-search"></span></a>
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

    @endsection

