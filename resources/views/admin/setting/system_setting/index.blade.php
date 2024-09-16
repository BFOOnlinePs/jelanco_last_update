@extends('home')
@section('title')
    اعدادات النظام
@endsection
@section('header_title')
    اعدادات النظام
@endsection
@section('header_link')
    الاعدادات
@endsection
@section('header_title_link')
    اعدادات النظام
@endsection
@section('content')
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">اعدادات النظام</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('setting.system_setting.create') }}" method="post">
                    @csrf
                    <input type="hidden" value="{{ !empty($data->id)??$data->id }}" name="id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Sidebar color</label>
                                <input value="{{ !empty($data->sidebar_color)??$data->sidebar_color }}" name="sidebar_color" class="form-control" type="color">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success" type="submit">حفظ</button>
                </form>
            </div>
        </div>
@endsection
