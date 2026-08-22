@extends('home')
@section('title')
    سجل نشاطات الأصناف
@endsection
@section('header_title')
    سجل نشاطات الأصناف
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    الأصناف
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fa fa-history"></i> سجل نشاطات الأصناف</h3>
        </div>
        <div class="card-body">
            <form method="get" action="{{ route('product.activity_logs') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>الصنف (اسم أو باركود)</label>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                   placeholder="ابحث بالاسم أو الباركود">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>نوع النشاط</label>
                            <select name="action" class="form-control select2bs4" style="width: 100%">
                                <option value="">الكل</option>
                                @foreach (\App\Models\ProductActivityLogModel::ACTION_LABELS as $code => $label)
                                    <option value="{{ $code }}" @if(request('action') === $code) selected @endif>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>الموظف</label>
                            <select name="user_id" class="form-control select2bs4" style="width: 100%">
                                <option value="">الكل</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @if(request('user_id') == $user->id) selected @endif>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>من تاريخ</label>
                            <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>إلى تاريخ</label>
                            <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-dark btn-sm"><i class="fa fa-search"></i> بحث</button>
                        <a href="{{ route('product.activity_logs') }}" class="btn btn-secondary btn-sm">إلغاء الفلتر</a>
                        <span class="float-left text-muted">عدد النتائج: {{ $logs->total() }}</span>
                    </div>
                </div>
            </form>

            <hr>

            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 20%">الصنف</th>
                            <th style="width: 15%">النشاط</th>
                            <th style="width: 12%">الموظف</th>
                            <th>التفاصيل</th>
                            <th style="width: 15%">التاريخ والوقت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>
                                    @if ($log->product)
                                        <a href="{{ route('product.details', ['id' => $log->product_id]) }}">
                                            {{ $log->product->product_name_ar ?: $log->product->product_name_en }}
                                        </a>
                                        <div class="text-muted" style="font-size: 11px">{{ $log->product->barcode }}</div>
                                    @else
                                        <span class="text-muted">صنف محذوف (#{{ $log->product_id }})</span>
                                    @endif
                                </td>
                                <td>{{ $log->action_label }}</td>
                                <td>{{ $log->user->name ?? 'غير معروف' }}</td>
                                <td>
                                    {{ $log->description }}
                                    @if ($log->old_value !== null || $log->new_value !== null)
                                        <div class="mt-1" style="font-size: 11px; padding: 5px; background: #f8f9fa; border-radius: 4px; border: 1px solid #ddd;">
                                            @if ($log->field_label)
                                                <span class="text-muted"><strong>{{ $log->field_label }}:</strong></span>
                                            @endif
                                            <span class="text-danger"><strong>القديمة:</strong> {{ $log->old_value_text }}</span>
                                            <i class="fa fa-arrow-left mx-1 text-muted"></i>
                                            <span class="text-success"><strong>الجديدة:</strong> {{ $log->new_value_text }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td style="direction: ltr;">{{ optional($log->created_at)->format('Y-m-d h:i A') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">لا توجد نشاطات مطابقة</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('.select2bs4').select2({theme: 'bootstrap4'});
        });
    </script>
@endsection
