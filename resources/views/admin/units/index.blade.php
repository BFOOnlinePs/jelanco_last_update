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
                    <form action="{{ route('units.index') }}" method="get">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" value="{{ $search }}"
                                   placeholder="ابحث باسم الوحدة بالعربي او بالانجليزي">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">بحث</button>
                                @if($search !== '')
                                    <a href="{{ route('units.index') }}" class="btn btn-secondary">الغاء البحث</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-md-left mt-2 mt-md-0">
                    <span class="text-muted">
                        عدد النتائج: {{ $data->total() }}
                    </span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>الاسم باللغة الانجليزية</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data as $key)
                        <tr>
                            <td>
                                <input type="text" class="form-control" onchange="updateUnitName({{ $key->id }})" id="unit_name_{{ $key->id }}" value="{{ $key->unit_name }}">
                            </td>
                            <td>
                                <input type="text" class="form-control" onchange="updateUnitName({{ $key->id }})" id="unit_name_en_{{ $key->id }}" value="{{ $key->unit_name_en }}">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">لا توجد وحدات مطابقة</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($data->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $data->links() }}
                </div>
            @endif

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
