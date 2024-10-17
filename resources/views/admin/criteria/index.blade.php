@extends('home')
@section('title')
    معايير التقييم
@endsection
@section('header_title')
    معايير التقييم
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    معايير التقييم
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('criteria.create') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="">اسم معيار التقييم</label>
                                    <input type="text" required placeholder="اسم المعيار" class="form-control"
                                        name="name">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">علامة المعيار</label>
                                    <input type="number" required value="5" placeholder="العلامة" class="form-control"
                                        name="mark">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">حفظ</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-sm table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>اسم معيار التقييم</th>
                                        <th>علامة المعيار</th>
                                        <th>الأدوار</th>
                                        <th>العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($criteria as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->mark }}</td>
                                            <td>
                                                <div class="form-group">
                                                    <label for="salesman_check_box_{{ $loop->index }}">موظف مشتريات</label>
                                                    <input type="checkbox" id="salesman_check_box_{{ $loop->index }}"
                                                        value="2" data-id="{{ $item->id }}"
                                                        @if (in_array('2', json_decode($item->role_id))) checked @endif>
                                                </div>
                                                <div class="form-group">
                                                    <label for="store_keeper_check_box_{{ $loop->index }}">امين
                                                        مستودع</label>
                                                    <input type="checkbox" id="store_keeper_check_box_{{ $loop->index }}"
                                                        value="9" data-id="{{ $item->id }}"
                                                        @if (in_array('9', json_decode($item->role_id))) checked @endif>
                                                </div>
                                                <div class="form-group">
                                                    <label for="finance_check_box_{{ $loop->index }}">المالية</label>
                                                    <input type="checkbox" id="finance_check_box_{{ $loop->index }}"
                                                        value="10" data-id="{{ $item->id }}"
                                                        @if (in_array('10', json_decode($item->role_id))) checked @endif>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('criteria.edit', $item->id) }}"
                                                    class="btn btn-success btn-sm">
                                                    <span class="fa fa-edit"></span>
                                                </a>
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
@endsection()
@section('script')
    <script>
        function update_role_id(id, role_id, isChecked) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };

            $.ajax({
                url: '{{ route('criteria.update_role_id') }}',
                method: 'post',
                headers: headers,
                data: {
                    id: id,
                    role_id: role_id,
                    is_checked: isChecked
                },
                success: function(data) {
                    if (data.success) {
                        toastr.success('تم تعديل البيانات بنجاح');
                    } else {
                        toastr.error('فشل تعديل البيانات');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('حدث خطأ ما');
                }
            });
        }

        // تطبيق الحدث على كل checkbox عند تغييره
        $(document).on('change', 'input[type="checkbox"]', function() {
            var id = $(this).data('id'); // الحصول على ID من الـ checkbox
            var role_id = $(this).val(); // الحصول على قيمة role_id
            var isChecked = $(this).is(':checked'); // التحقق إذا كان الـ checkbox محدداً أم لا
            update_role_id(id, role_id, isChecked); // استدعاء الدالة مع القيم المناسبة
        });
    </script>
@endsection
