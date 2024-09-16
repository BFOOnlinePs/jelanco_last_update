@extends('home')
@section('title')
    تعديل سجل متابعة
@endsection
@section('header_title')
    سجل متابعة
@endsection
@section('header_link')
    تعديل سجل متابعة
@endsection
@section('header_title_link')
    تعديل سجل متابعة
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.supplier.update_for_supplier') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $data->id }}">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">النص</label>
                            <textarea class="form-control" name="note_text" id="" cols="30" rows="3">{{ $data->note_text }}</textarea>
                        </div>
                    </div>
                    @if(!empty($data->attachment))
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">المرفق</label>
                                <img style="width: 150px" src="{{ asset('storage/attachment/'.$data->attachment) }}" alt="">
                            </div>
                        </div>
                    @endif
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">ارفاق مرفق</label>
                            <input class="form-control" name="attachment" type="file">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-block"><i
                        class="fa-solid fa-floppy-disk"></i> تعديل
                </button>
            </form>
        </div>
    </div>
@endsection

