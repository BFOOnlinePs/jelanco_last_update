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
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">
        <div class="card-header text-center bg-warning">
            <h5 class="text-bold">تعديل المورد ( {{ $data->name }} )</h5>
        </div>
        <div class="card-body">

            <form class="row" action="{{ route('users.supplier.update',['id'=>$data->id]) }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الاسم الكامل</label>
                                <input value="{{ old('name',$data->name) }}" placeholder="الاسم الكامل"
                                       name="name" class="form-control"
                                       type="text">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الايميل</label>
                                <input value="{{ old('email',$data->email) }}" name="email"
                                       placeholder="الايميل" class="form-control"
                                       type="text">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">كلمة المرور</label>
                                <input {{ old('password') }} placeholder="كلمة المرور" name="password"
                                       class="form-control"
                                       type="text">
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>رقم الهاتف الاول</label>
                                <input style="direction: ltr !important" value="{{ old('user_phone1',$data->user_phone1) }}"
                                       placeholder="رقم الهاتف الاول" class="form-control"
                                       name="user_phone1" type="text">
                                @error('user_phone1')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">رقم الهاتف الثاني</label>
                                <input style="direction: ltr !important" value="{{ old('user_phone2',$data->user_phone2) }}"
                                       placeholder="رقم الهاتف الثاني" class="form-control"
                                       name="user_phone2" type="text">
                                @error('user_phone2')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الموقع الالكتروني</label>
                                <input value="{{ old('user_website',$data->user_website) }}"
                                       placeholder="الموقع الالكتروني" name="user_website"
                                       class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">العنوان الكامل</label>
                                <textarea class="form-control" placeholder="العنوان الكامل"
                                          name="user_address" id="" cols="30"
                                          rows="3">{{ old('user_address',$data->user_address) }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">مجال العمل</label>
                                   <select multiple="multiple" class="form-control select2bs4" name="user_category[]" id="">
                                       @foreach ($user_category as $key)
                                           @php
                                               $userCategoryArray = json_decode($data->user_category) ?? [];
                                           @endphp

                                           <option @if(in_array($key->id, $userCategoryArray)) selected @endif value="{{ $key->id }}">{{ $key->name }}</option>
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
                                            @php
                                               $userFollowBy = json_decode($data->follow_by) ?? [];
                                           @endphp
                                            <option @if(in_array($key->id,$userFollowBy)) selected @endif value="{{ $key->id }}">{{ $key->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
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
                        <button type="submit" class="btn btn-success btn-block"><i
                            class="fa-solid fa-floppy-disk"></i> تعديل
                    </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <h6 class="text-center">الصورة الشخصية</h6>
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

