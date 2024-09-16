@extends('home')
@section('title')
    اضافة امين مستودع
@endsection
@section('header_title')
    اضافة امين مستودع
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    اضافة امين مستودع
@endsection
@section('content')

    <div class="card">
        <div class="card-header text-center">
            <h5 class="text-bold">اضافة أمين مستودع</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.storekeeper.create') }}" method="post" enctype="multipart/form-data">

                <div class="row">
                    @csrf
                    <div class="col-md-12">
                        <div>
                            <div class="card card-warning">
                                <div class="card-header text-center">
                                    <span>المعلومات العامة</span>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="">الاسم الكامل</label>
                                                <input value="{{ old('name') }}" placeholder="الاسم الكامل" name="name"
                                                       class="form-control"
                                                       type="text">
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">الايميل</label>
                                                <input value="{{ old('email') }}" name="email" placeholder="الايميل"
                                                       class="form-control"
                                                       type="text">
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">كلمة المرور</label>
                                                <input {{ old('password') }} placeholder="كلمة المرور" name="password"
                                                       class="form-control"
                                                       type="text" value="<?php echo rand(11111,9999999) ?>">
                                                @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="row form-group">
                                                <div class="col">
                                                    <label>رقم الهاتف الاول</label>
                                                    <input style="direction: ltr !important" value="{{ old('user_phone1') }}"
                                                           placeholder="رقم الهاتف الاول" class="form-control"
                                                           name="user_phone1" type="text">
                                                    @error('user_phone1')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <label for="">رقم الهاتف الثاني</label>
                                                    <input style="direction: ltr !important" value="{{ old('user_phone2') }}"
                                                           placeholder="رقم الهاتف الثاني" class="form-control"
                                                           name="user_phone2" type="text">
                                                    @error('user_phone2')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">الموقع الالكتروني</label>
                                                <input {{ old('user_website') }} placeholder="الموقع الالكتروني"
                                                       name="user_website"
                                                       class="form-control" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label for="">العنوان الكامل</label>
                                                <textarea class="form-control" placeholder="العنوان الكامل"
                                                          name="user_address" id="" cols="30"
                                                          rows="3"></textarea>
                                            </div>
                                            <div hidden class="form-group">
                                                <label for="">تصنيف المستخدم</label>
                                                <input class="form-control" type="text" name="user_category"
                                                       placeholder="تنصيف المستخدم">
                                            </div>
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
                                            <div class="form-group">
                                                <label for="">ملاحظات</label>
                                                <textarea placeholder="الملاحظات" class="form-control" name="user_notes"
                                                          id="" cols="30"
                                                          rows="5">{{ old('user_notes') }}</textarea>
                                                @error('user_notes')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

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
                <button class="btn btn-success" style="width: 300px">حفظ</button>
            </form>

        </div>

    </div>

@endsection

