@extends('home')
@section('title')
    إعدادات النظام
@endsection
@section('header_title')
    إعدادات النظام
@endsection
@section('header_link')
    الاعدادات
@endsection
@section('header_title_link')
    إعدادات النظام
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">المظهر</h2>
                </div>
                <form action="{{ route('setting.system_setting.create') }}" method="post">
                    @csrf
                    <input type="hidden" value="{{ $data->id ?? '' }}" name="id">
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <label for="sidebar_color">لون القائمة الجانبية</label>
                            <input id="sidebar_color" value="{{ $data->sidebar_color ?? '#0f1b3d' }}" name="sidebar_color"
                                   class="form-control" type="color" aria-describedby="sidebar_color_help">
                            <small id="sidebar_color_help" class="form-text text-muted">
                                يُفضّل اختيار لون داكن حتى تبقى نصوص القائمة واضحة. اللون الافتراضي: <bdi>#0f1b3d</bdi>
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-floppy-disk" aria-hidden="true"></i> حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
