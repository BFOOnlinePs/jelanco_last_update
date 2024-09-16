@extends('home')
@section('title')
    الموردين
@endsection
@section('header_title')
    الموردين
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    الموردين
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">
        <div class="card-header text-center">
            <h5 class="text-bold">تفاصيل المورد ( {{ $data->name }} )</h5>
        </div>
        <div class="card-body">
            {{--            <form action="{{ route('users.supplier.create') }}" method="post" enctype="multipart/form-data">--}}

            <div class="row">
                @csrf
                <div class="col-md-4">
                    <div id="accordion">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseOne"
                                       aria-expanded="false">
                                        المعلومات العامة
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                                <div class="card-body">
                                    <div class="card-body p-4">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group text-center">
                                                    <img width="150"
                                                         src="{{ asset('storage/user_photo/'.$data->user_photo) }}"
                                                         alt="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">الاسم :</label>
                                                    <span class="form-control">{{ $data->name }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">الايميل :</label>
                                                    <span class="form-control">{{ $data->email }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">رقم الهاتف الاول :</label>
                                                    <span class="form-control">{{ $data->user_phone1 }}</span>
                                                </div>
                                                <div class="form-group">
                                                    @if($data->user_phone2 == '')
                                                        <label for="">رقم الهاتف الثاني :</label>
                                                        <span class="form-control">لا يوجد</span>
                                                    @else
                                                        <label for="">رقم الهاتف الثاني :</label>
                                                        <span class="form-control">{{ $data->user_phone2 }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="">حالة المستخدم</label>
                                                    @if($data->status == 1)
                                                        <span class="form-control text-success">فعال</span>
                                                    @elseif($data->status == 0)
                                                        <span class="text-danger form-control">غير فعال</span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="">ملاحظات : </label>
                                                    <textarea readonly class="form-control" name="" id="" cols="30"
                                                              rows="3">{{ $data->user_notes }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">الموقع الالكتروني : <span><a
                                                                href="">{{ $data->user_website }}</a></span></label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">العنوان :</label>
                                                    <textarea readonly class="form-control" name="" id="" cols="30"
                                                              rows="3">{{ $data->user_address }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">مجال العمل :</label>
                                                    <span class="form-control"></span>
                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-danger">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseTwo"
                                       aria-expanded="false">
                                        معلومات البنك
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="collapse" data-parent="#accordion" style="">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>رقم حساب البنك :</label>
                                        <span
                                            class="form-control">{{ $data->user_account_number }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label>اسم البنك :</label>
                                        <span
                                            class="form-control">{{ $data->user_bank_name }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label>عنوان البنك :</label>
                                        <textarea disabled class="form-control" name="" id=""
                                                  cols="30"
                                                  rows="3">{{ $data->user_bank_address }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Swift code :</label>
                                        <span
                                            class="form-control">{{ $data->user_swift_code }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label>IBAN Number :</label>
                                        <span
                                            class="form-control">{{ $data->user_iban_number }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-info">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseThree"
                                       aria-expanded="true">
                                        معلومات التواصل
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="collapse show" data-parent="#accordion" style="">
                                <div class="card-body">
                                    <div class="card-body">
                                        <label for="">جهة التواصل</label>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#modal-default">
                                            اضافة جديد
                                        </button>
                                        <div class="modal fade" id="modal-default">
                                            <div class="modal-dialog">
                                                <form action="{{ route('company_contact_person.supplier.create') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="text" hidden name="company_id" value="{{ $data->id }}">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">اضافة جهة تواصل جديدة</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="">الاسم</label>
                                                                <input name="contact_name" class="form-control" type="text"
                                                                       placeholder="الاسم">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">رقم الهاتف</label>
                                                                <input name="mobile_number" class="form-control" type="text"
                                                                       placeholder="رقم الهاتف">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">البريد الالكتروني</label>
                                                                <input name="email" class="form-control" type="text"
                                                                       placeholder="البريد الالكتروني">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">رقم WhatsApp</label>
                                                                <input name="whats_app_number" class="form-control" type="text"
                                                                       placeholder="رقم الواتس اب">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">رقم WeChat</label>
                                                                <input name="wechat_number" class="form-control" type="text"
                                                                       placeholder="رقم وي شات">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">العنوان</label>
                                                                <textarea class="form-control" name="address" id="" cols="30"
                                                                          rows="2" placeholder="العنوان"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">الصورة</label>
                                                                <div class="custom-file">
                                                                    <input name="photo" type="file" class="custom-file-input"
                                                                           id="customFile">
                                                                    <label class="custom-file-label" for="customFile">تحميل
                                                                        صورة</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">اغلاق
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">حفظ</button>
                                                        </div>

                                                    </div>
                                                </form>

                                            </div>

                                        </div>

                                        <table style="font-size: 14px" id="contact_person_table"
                                               class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>الاسم</td>
                                                <td>العمليات</td>
                                                <td></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($company_contact_person as $key)
                                                <tr>
                                                    <td>{{ $key->id }}</td>
                                                    <td>{{ $key->contact_name }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn btn-dark">تفاصيل</button>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-danger">X</button>
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

                </div>
                <div class="col-md-8">
                    <div>
                        <div class="card card-info">
                            <div class="card-header text-center">
                                <span>طلبات المورد</span>
                            </div>

                            <div class="card-body p-4">
                                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="example1"
                                                   class="table table-bordered table-striped dataTable dtr-inline"
                                                   aria-describedby="example1_info">
                                                <thead>
                                                <tr>
                                                    <th class="sorting sorting_asc" tabindex="0"
                                                        aria-controls="example1" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Rendering engine: activate to sort column descending">
                                                        Rendering engine
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending">
                                                        Browser
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending">
                                                        Platform(s)
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending">
                                                        Engine version
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending">
                                                        CSS grade
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--                        <div class="col-md-12">--}}
                    {{--                            <button type="submit" class="btn btn-success btn-block"><i--}}
                    {{--                                    class="fa-solid fa-floppy-disk"></i> حفظ--}}
                    {{--                            </button>--}}
                    {{--                        </div>--}}
                </div>
            </div>

            {{--            </form>--}}

        </div>

    </div>

@endsection

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


    <script>
        function add_contact_person() {
            var contact_person_table = document.getElementById('contact_person_table');
            var count = {{ \App\Models\CompanyContactPersonModel::count() }};
            if (contact_person_table.rows.length == count + 1) {
                var new_row = contact_person_table.insertRow();
                var cell1 = new_row.insertCell();
                var cell2 = new_row.insertCell();
                var cell3 = new_row.insertCell();
                var cell4 = new_row.insertCell();
                cell1.innerText = '2';
                cell2.innerText = 'test2';
                cell3.innerHTML = '<button class="btn btn-sm btn-dark">تفاصيل</button>';
                cell4.innerHTML = '<button class="btn btn-sm btn-danger">X</button>';
            } else {
                alert('يرجى تعبئة الحقل الفارغ')
            }
            console.log(contact_person_table.rows.length);
            // console.log(count);

        }
    </script>
@endsection

