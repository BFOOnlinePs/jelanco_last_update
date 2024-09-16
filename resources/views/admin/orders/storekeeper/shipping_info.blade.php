@extends('home')
@section('title')
    تفاصيل الشحنة
@endsection
@section('header_title')
    تفاصيل الشحنة
@endsection
@section('header_link')
    طلبيات شراء
@endsection
@section('header_title_link')
    تفاصيل الشحنة
@endsection
@section('style')

@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    @if(empty($data))
        <div class="card">
            <div class="card-body">
                لا يوجد معلومات للشحن
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">شركة الشحن</label>
                            <span class="form-control">{{ $data['shipping']->name ?? '' }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">السعر</label>
                            <input readonly value="{{ $data->price ?? '' }}" type="text" placeholder="يرجى كتابة السعر" name="price"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">العملة</label>
                            <span class="form-control">{{ $data['currency']->currenct_name ?? '' }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">المرفقات</label>
                            <br>
                            <p>{{ $data->attachment ?? '' }}</p>
                            @if(!empty($data->attachment))
                                <a class="btn btn-primary btn-sm"
                                   href="{{ asset('storage/attachment/'.$data->attachment) }}" download="attachment">تحميل
                                    الملف</a>
                            @else
                                لا يوجد مرفقات
                            @endif
                            {{--                            <input type="file" name="attachment" class="form-control">--}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">نوع الشحن</label>
                            @if($data->shipping_type == 1)
                                <span class="form-control">بري</span>
                            @elseif($data->shipping_type == 2)
                                <span class="form-control">جوي</span>
                            @elseif($data->shipping_type == 3)
                                <span class="form-control">بحري</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">تصنيف الشحن</label>
                            @if($data->shipping_rating == 1)
                                <span class="form-control">جزئي</span>
                            @elseif($data->shipping_rating == 2)
                                <span class="form-control">حاوية</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row" id="partial_charge">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">CBN</label>
                            <input readonly value="{{ $data->cbn }}" name="cbn" type="text" class="form-control"
                                   placeholder="CBN">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">الوزن الاجمالي</label>
                            <input readonly value="{{ $data->total_weight }}" name="total_weight" type="text"
                                   class="form-control" placeholder="الوزن الاجمالي">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">الوزن الصافي</label>
                            <input readonly value="{{ $data->net_weight }}" name="net_weight" type="text"
                                   class="form-control" placeholder="الوزن الصافي">
                        </div>
                    </div>
                </div>
                <div class="row" id="container_charge">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">حجم الحاوية</label>
                            @if($data->container_size == 20)
                                <span class="form-control">20 قدم</span>
                            @elseif($data->container_size == 40)
                                <span class="form-control">40 قدم</span>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">التبريد</label>
                            @if($data->cooling_type == 1)
                                <span class="form-control">نعم</span>
                            @elseif($data->cooling_type == 0)
                                <span class="form-control">لا</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">طرق الشحن</label>
                            @if($data->shipping_method == 1)
                                <span class="form-control">من المصنع ( EXW )</span>
                            @elseif($data->shipping_method == 2)
                                <span class="form-control">من ميناء المورد ( FOB )</span>
                            @elseif($data->shipping_method == 3)
                                <span class="form-control">من ميناء المشتري مع تأمين ( CIF )</span>
                            @elseif($data->shipping_method == 4)
                                <span class="form-control">من ميناء المشتري بدون تأمين ( C&F )</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <labe>الملاحظات</labe>
                            <textarea readonly name="note" class="form-control" placeholder="يرجى كتابة الملاحظات" id=""
                                      cols="30" rows="3">{{ $data->note }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection


