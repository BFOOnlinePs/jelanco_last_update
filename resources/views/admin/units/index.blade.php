@extends('home')
@section('title')
    الوحدات
@endsection
@section('header_title')
    الوحدات
@endsection
@section('header_link')
    الاصناف
@endsection
@section('header_title_link')
    الوحدات
@endsection
@section('content')

    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    @include('admin.product.home_menu')
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-default">اضافة وحدة
    </button>
    <div class="card">

        <div class="card-header">
            <h3 class="text-center">قائمة الوحدات</h3>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" id="input_search" class="form-control" value="{{ $search }}"
                               placeholder="ابحث باسم الوحدة بالعربي او بالانجليزي" autocomplete="off">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary" onclick="clearUnitsSearch()">الغاء البحث</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="units_table">
                @include('admin.units.ajax.units_table',['data'=>$data])
            </div>

            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <form action="{{ route('units.create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">اضافة وحدة</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">اسم الوحدة</label>
                                    <input name="unit_name" class="form-control" type="text"
                                           placeholder="اكتب اسم الوحدة" required>
                                </div>
                                <div class="form-group">
                                    <label for="">اسم الوحدة</label>
                                    <input name="unit_name_en" class="form-control" type="text"
                                           placeholder="اكتب اسم باللغة الانجليزية">
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                                <button type="submit" class="btn btn-primary">حفظ</button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

@endsection()

@section('script')
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script>
        function fetchUnits(page) {
            page = page || 1;
            var search = document.getElementById('input_search').value;

            AjaxSearch.request('units.table', {
                url: '{{ route('units.index') }}',
                type: 'get',
                data: {
                    'search': search,
                    'page': page
                },
                beforeSend: function () {
                    $('#units_table').css('opacity', '0.5');
                },
                success: function (data) {
                    $('#units_table').html(data);
                },
                error: function () {
                    toastr.error('حدث خطأ اثناء جلب البيانات');
                },
                complete: function () {
                    $('#units_table').css('opacity', '1');
                }
            });
        }

        function clearUnitsSearch() {
            document.getElementById('input_search').value = '';
            fetchUnits(1);
        }

        $(document).on('click', '#units_table .pagination a', function (e) {
            e.preventDefault();
            var href = $(this).attr('href');
            if (!href) {
                return;
            }
            var page = new URL(href, window.location.origin).searchParams.get('page') || 1;
            fetchUnits(page);
        });

        AjaxSearch.bind('#input_search', function () {
            fetchUnits(1);
        });

        function updateUnitName(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('units.updateUnitName') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'unit_name': document.getElementById('unit_name_' + id).value,
                    'unit_name_en': document.getElementById('unit_name_en_' + id).value
                },
                success: function (data) {
                    toastr.success('تم تعديل اسم الوحدة بنجاح')
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    toastr.error('حدث خطأ اثناء التعديل')
                }
            });
        }
    </script>

@endsection

{{-- Mohamad Maraqa--}}
