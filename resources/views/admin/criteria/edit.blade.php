@extends('home')
@section('title')
    المعايير
@endsection
@section('header_title')
    المعايير
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    المعايير
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('criteria.update') }}" method="post">
                        @csrf
                        <div class="row">
                            <input type="text" hidden name="id" value="{{ $data->id }}">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="">اسم المعيار</label>
                                    <input type="text" value="{{ $data->name }}" required placeholder="اسم المعيار"
                                        class="form-control" name="name">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">العلامة</label>
                                    <input type="number" value="{{ $data->mark }}" required value="5"
                                        placeholder="العلامة" class="form-control" name="mark">
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
@endsection()
