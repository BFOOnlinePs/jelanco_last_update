@extends('home')
@section('title')
    تعديل شركات التخليص
@endsection
@section('header_title')
    تعديل شركات التخليص
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    تعديل شركات التخليص
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">
        <div class="card-header text-center">
            <h5 class="text-bold">تعديل المورد ( {{ $data->name }} )</h5>
        </div>
        <div class="card-body">

            <form action="{{ route('users.clearance_companies.update',['id'=>$data->id]) }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
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
                                                <input value="{{ old('name',$data->name) }}" placeholder="الاسم الكامل"
                                                       name="name" class="form-control"
                                                       type="text">
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">الايميل</label>
                                                <input value="{{ old('email',$data->email) }}" name="email"
                                                       placeholder="الايميل" class="form-control"
                                                       type="text">
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div hidden class="form-group">
                                                <label for="">كلمة المرور</label>
                                                <input {{ old('password') }} placeholder="كلمة المرور" name="password"
                                                       class="form-control"
                                                       type="text">
                                                @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="row form-group">
                                                <div class="col">
                                                    <label>رقم الهاتف الاول</label>
                                                    <input value="{{ old('user_phone1',$data->user_phone1) }}"
                                                           placeholder="رقم الهاتف الاول" class="form-control"
                                                           name="user_phone1" type="text">
                                                    @error('user_phone1')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <label for="">رقم الهاتف الثاني</label>
                                                    <input value="{{ old('user_phone2',$data->user_phone2) }}"
                                                           placeholder="رقم الهاتف الثاني" class="form-control"
                                                           name="user_phone2" type="text">
                                                    @error('user_phone2')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">الموقع الالكتروني</label>
                                                <input value="{{ old('user_website',$data->user_website) }}"
                                                       placeholder="الموقع الالكتروني" name="user_website"
                                                       class="form-control" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label for="">العنوان الكامل</label>
                                                <textarea class="form-control" placeholder="العنوان الكامل"
                                                          name="user_address" id="" cols="30"
                                                          rows="3">{{ old('user_address',$data->user_address) }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">تصنيف المستخدم</label>
                                                <select class="form-control" name="user_category" id="">
                                                    <option value="">اختر تصنيف للمستخدم</option>
                                                    @foreach ($user_category as $key)
                                                        <option @if($data->user_category == $key->id) selected @endif value="{$key->id}">{{ $key->name }}</option>
                                                    @endforeach
                                                   </select>                                            </div>
                                            <div class="form-group">


                                                <div class="row">
                                                    <div class="col-md-5 text-center">

                                                        <img width="150"
                                                             src="{{ asset('storage/user_photo/'. $data->user_photo) }}"
                                                             alt="">
                                                        <br>
                                                        <label for="exampleInputFile">الصورة الشخصية</label>

                                                    </div>
                                                    <div class="col-md-7 pt-5">
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">رفع</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>


{{--                                                <div class="input-group mt-3">--}}
{{--                                                    <div class="custom-file">--}}

{{--                                                    </div>--}}
{{--                                                    <div class="input-group-append">--}}
{{--                                                        <span class="input-group-text">رفع</span>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                                @error('user_photo')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">ملاحظات</label>
                                                <textarea placeholder="الملاحظات" class="form-control" name="user_notes"
                                                          id="" cols="30"
                                                          rows="5">{{ old('user_notes',$data->user_notes) }}</textarea>
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
                    <div class="col-md-6">
                        <div>
                            <div class="card card-danger">
                                <div class="card-header text-center">
                                    <span>معلومات البنك</span>
                                </div>

                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="">اسم المستفيد</label>
                                                <input class="form-control"
                                                       value="{{ old('account_owner',$data->account_owner) }}"
                                                       type="text" name="account_owner" placeholder="اسم البنك">
                                            </div>
                                            <div class="form-group">
                                                <label for="">رقم الحساب البنكي</label>
                                                <input class="form-control"
                                                       value="{{ old('user_account_number',$data->user_account_number) }}"
                                                       type="text" name="user_account_number"
                                                       placeholder="رقم الحساب البنكي">
                                            </div>
                                            <div class="form-group">
                                                <label for="">اسم البنك</label>
                                                <input class="form-control"
                                                       value="{{ old('user_bank_name',$data->user_bank_name) }}"
                                                       type="text" name="user_bank_name" placeholder="اسم البنك">
                                            </div>
                                            <div class="form-group">
                                                <label for="">عنوان البنك</label>
                                                <textarea class="form-control" placeholder="عنوان البنك"
                                                          name="user_bank_address" id=""
                                                          cols="30"
                                                          rows="3">{{ old('user_bank_address',$data->user_bank_address) }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Swift code</label>
                                                <input class="form-control"
                                                       value="{{ old('user_swift_code',$data->user_swift_code) }}"
                                                       name="user_swift_code" type="text" placeholder="Swift code">
                                            </div>
                                            <div class="form-group">
                                                <label for="">IBAN Number</label>
                                                <input class="form-control"
                                                       value="{{ old('user_iban_number',$data->user_iban_number) }}"
                                                       name="user_iban_number" type="text" placeholder="IBAN Number">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block"><i
                                    class="fa-solid fa-floppy-disk"></i> تعديل
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

