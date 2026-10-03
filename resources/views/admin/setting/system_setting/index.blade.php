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
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">شعار الشركة</h2>
                </div>
                <form action="{{ route('setting.system_setting.update_logo') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="jl-logo-setting">
                            <div class="jl-logo-setting__preview">
                                <img id="company_logo_preview" src="{{ App\Models\SystemSettingModel::logoUrl() }}"
                                     alt="شعار الشركة الحالي">
                            </div>
                            <div class="jl-logo-setting__body">
                                <label for="company_logo">رفع شعار جديد</label>
                                <input id="company_logo" name="company_logo" type="file"
                                       accept="image/png,image/jpeg,image/webp"
                                       class="form-control @error('company_logo') is-invalid @enderror"
                                       aria-describedby="company_logo_help">
                                @error('company_logo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small id="company_logo_help" class="form-text text-muted">
                                    يظهر في القائمة الجانبية وصفحة تسجيل الدخول وأيقونة المتصفح.
                                    يُفضّل PNG بخلفية شفافة، والحد الأقصى 2 ميجابايت.
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex flex-wrap align-items-center" style="gap: .5rem">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-floppy-disk" aria-hidden="true"></i> حفظ الشعار</button>
                        @if (App\Models\SystemSettingModel::hasCustomLogo())
                            <button class="btn btn-outline-secondary" type="submit" form="reset_logo_form">
                                <i class="fas fa-rotate-left" aria-hidden="true"></i> استعادة الشعار الافتراضي
                            </button>
                        @endif
                    </div>
                </form>
                <form id="reset_logo_form" action="{{ route('setting.system_setting.update_logo') }}" method="post"
                      onsubmit="return confirm('هل تريد حذف الشعار الحالي والعودة للشعار الافتراضي؟')">
                    @csrf
                    <input type="hidden" name="remove_logo" value="1">
                </form>
            </div>
        </div>
    </div>
@endsection
@section('style')
    <style>
        .jl-logo-setting {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .jl-logo-setting__preview {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 132px;
            height: 132px;
            padding: 12px;
            background: var(--jl-surface-2);
            border: 1px dashed var(--jl-border-strong);
            border-radius: var(--jl-radius-lg);
        }

        .jl-logo-setting__preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .jl-logo-setting__body {
            flex: 1;
            min-width: 0;
        }

        @media (max-width: 575.98px) {
            .jl-logo-setting {
                flex-direction: column;
                align-items: stretch;
            }

            .jl-logo-setting__preview {
                align-self: center;
            }
        }
    </style>
@endsection
@section('script')
    <script>
        // معاينة فورية للشعار المختار قبل الحفظ
        document.getElementById('company_logo').addEventListener('change', function () {
            var file = this.files && this.files[0];
            if (file && file.type.indexOf('image/') === 0) {
                document.getElementById('company_logo_preview').src = URL.createObjectURL(file);
            }
        });
    </script>
@endsection
