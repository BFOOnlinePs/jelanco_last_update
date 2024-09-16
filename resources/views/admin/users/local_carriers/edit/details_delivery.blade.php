@extends('home')
@section('title')
    تعديل تقدير التكلفة
@endsection
@section('header_title')
    تعديل تقدير التكلفة
@endsection
@section('header_link')
    تقدير التكلفة
@endsection
@section('header_title_link')
    تعديل تقدير التكلفة
@endsection
@section('content')

    <div class="card">
        <div class="card-header text-center">
            <h5 class="text-bold">تعديل تقدير التكلفة{{ $data->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.local_carriers.update_delivery') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $data->id }}" id="id">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">تقدير التكلفة</label>
                                <select class="form-control" name="element_cost_id" id="">
                                    @foreach($element_cost as $key)
                                        <option value="{{ $key->id }}">{{ $key->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">التكلفة</label>
                                <input value="{{ $data->estimation_price }}" name="estimation_price" type="text" class="form-control" placeholder="تقدير التكلفة">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">العملة</label>
                                <select class="form-control" name="currency_id" id="">
                                    @foreach($currency as $key)
                                        <option value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success">حفظ <span class="fa fa-edit"></span></button>
            </form>
        </div>
    </div>
@endsection

