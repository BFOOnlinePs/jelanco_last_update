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
@section('style')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="card">
{{--        <div class="card-header text-center">--}}
{{--            <h5 class="text-bold">اضافة مورد</h5>--}}
{{--        </div>--}}
        <div class="card-body">
            <form action="{{ route('users.supplier.create') }}" method="post" enctype="multipart/form-data">

                <div class="row">
                    @csrf
                    <div class="col-md-12">
                        <div>
{{--                            <div class="card card-warning">--}}
{{--                                <div class="card-header text-center">--}}
{{--                                    <span>المعلومات العامة</span>--}}
{{--                                </div>--}}
{{--                                <div class="card-body p-4">--}}
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">الاسم الكامل</label>
                                                        <input required value="{{ old('name') }}" placeholder="الاسم الكامل" name="name" class="form-control"
                                                               type="text">
                                                        @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">الايميل</label>
                                                        <input required value="{{ old('email') }}" name="email" placeholder="الايميل" class="form-control"
                                                               type="text">
                                                        @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div hidden="" class="col-md-6">
                                                    <div hidden class="form-group">
                                                        <label for="">كلمة المرور</label>
                                                        <input {{ old('password') }} placeholder="كلمة المرور" name="password" class="form-control"
                                                               type="text" value="<?php echo rand(11111,9999999) ?>">
                                                        @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row form-group">
                                                        <div class="col">
                                                            <label>رقم الهاتف الاول</label>
                                                            <input style="direction: ltr !important" required value="{{ old('user_phone1') }}" placeholder="رقم الهاتف الاول" class="form-control"
                                                                   name="user_phone1" type="text">
                                                            @error('user_phone1')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col">
                                                            <label for="">رقم الهاتف الثاني</label>
                                                            <input style="direction: ltr !important" value="{{ old('user_phone2') }}" placeholder="رقم الهاتف الثاني" class="form-control"
                                                                   name="user_phone2" type="text">
                                                            @error('user_phone2')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">الموقع الالكتروني</label>
                                                        <input {{ old('user_website') }} placeholder="الموقع الالكتروني" name="user_website"
                                                               class="form-control" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">العنوان الكامل</label>
                                                        <textarea class="form-control" placeholder="العنوان الكامل" name="user_address" id="" cols="30"
                                                                  rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">مجال الاختصاص</label>
                                                        <select multiple="multiple" class="form-control select2bs4" name="user_category[]" id="">
                                                            <option value="">اختر مجال الاختصاص</option>
                                                            @foreach ($user_category as $key)
                                                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @if (auth()->user()->user_role == 1)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">متابعة بواسطة</label>
                                                            <select required class="form-control select2bs4" multiple="multiple" name="follow_by[]" id="">
                                                                @foreach ($officer as $key)
                                                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">ملاحظات</label>
                                                        <textarea placeholder="الملاحظات" class="form-control" name="user_notes" id="" cols="30"
                                                                  rows="5">{{ old('user_notes') }}</textarea>
                                                        @error('user_notes')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row text-center">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">الصورة الشخصية</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input value="{{ old('user_photo') }}" name="user_photo"
                                                                       type="file" class="custom-file-input"
                                                                       id="exampleInputFile">
                                                                <label class="custom-file-label" for="exampleInputFile">رفع
                                                                    صورة</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">رفع</span>
                                                            </div>
                                                        </div>
                                                        @error('user_photo')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                        <button type="submit" class="btn btn-success btn-block"><i
                                class="fa-solid fa-floppy-disk"></i> حفظ
                        </button>
                    </div>
{{--                    <div class="col-md-6">--}}
{{--                        <div>--}}
{{--                            <div class="card card-danger">--}}
{{--                                <div class="card-header text-center">--}}
{{--                                    <span>معلومات البنك</span>--}}
{{--                                </div>--}}

{{--                                <div class="card-body p-4">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="">اسم جهة الحساب</label>--}}
{{--                                                <input class="form-control" type="text" name="account_owner" placeholder="اسم جهة الحساب">--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="">رقم الحساب البنكي</label>--}}
{{--                                                <input class="form-control" type="text" name="user_account_number" placeholder="رقم الحساب البنكي">--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="">اسم البنك</label>--}}
{{--                                                <input class="form-control" type="text" name="user_bank_name" placeholder="اسم البنك">--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="">عنوان البنك</label>--}}
{{--                                                <textarea class="form-control" placeholder="عنوان البنك" name="user_bank_address" id=""--}}
{{--                                                          cols="30" rows="3"></textarea>--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="">Swift code</label>--}}
{{--                                                <input class="form-control" name="user_swift_code" type="text" placeholder="Swift code">--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="">IBAN Number</label>--}}
{{--                                                <input class="form-control" name="user_iban_number" type="text" placeholder="IBAN Number">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-12">--}}
{{--                            <button type="submit" class="btn btn-success btn-block"><i--}}
{{--                                    class="fa-solid fa-floppy-disk"></i> حفظ--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

            </form>

        </div>

    </div>

@endsection

@section('script')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>
@endsection

