@if(auth()->user()->user_role == 11)
    <div class="pb-2 row d-flex justify-content-center">
        <a class="btn btn-app @if(!\App\Models\ShippingPriceOfferModel::where('order_id',$order->id)->get()->isEmpty()) bg-gradient-success @else bg-gradient-info @endif text-white" href="{{ route('procurement_officer.orders.shipping.index',['order_id'=>$order->id]) }}">
            <i class="fa fa-plane">

            </i>
            شحن
        </a>
    </div>
@else
    <div class="pb-2 row d-flex justify-content-center">
        <a class="btn btn-app @if(!\App\Models\OrderItemsModel::where('order_id',$order->id)->get()->isEmpty()) bg-gradient-success @else bg-gradient-info @endif text-white"  href="{{ route('procurement_officer.orders.product.index',['order_id'=>$order->id]) }}">
            <i class="fa fa-list">

            </i>
            الأصناف
        </a>
        <a class="btn btn-app @if(!\App\Models\PriceOffersModel::where('order_id',$order->id)->get()->isEmpty()) bg-gradient-success @else bg-gradient-info @endif text-white" href="{{ route('procurement_officer.orders.price_offer.index',['order_id'=>$order->id]) }}">
            <i class="fa fa-bars">

            </i>
            عروض الأسعار
        </a>
        <a class="btn btn-app @if(!\App\Models\PriceOffersModel::where('order_id',$order->id)->where('status',1)->get()->isEmpty()) bg-gradient-success @else bg-gradient-info @endif text-white" href="{{ route('procurement_officer.orders.anchor.index',['order_id'=>$order->id]) }}">
            <i class="fa fa-thumbs-up">

            </i>
            الترسية
        </a>
        <a class="btn btn-app @if(!(\App\Models\CashPaymentsModel::where('order_id',$order->id)->get()->isEmpty()) || !(\App\Models\LetterBankModel::where('order_id',$order->id)->get()->isEmpty())) bg-gradient-success @else bg-gradient-info @endif text-white" href="{{ route('procurement_officer.orders.financial_file.index',['order_id'=>$order->id]) }}">
            <i class="fa fa-dollar">

            </i>
            الملف المالي
        </a>
        <a class="btn btn-app @if(!\App\Models\ShippingPriceOfferModel::where('order_id',$order->id)->get()->isEmpty()) bg-gradient-success @else bg-gradient-info @endif text-white" href="{{ route('procurement_officer.orders.shipping.index',['order_id'=>$order->id]) }}">
            <i class="fa fa-plane">

            </i>
            شحن
        </a>
        <a class="btn btn-app @if(!\App\Models\OrderInsuranceModel::where('order_id',$order->id)->get()->isEmpty()) bg-gradient-success @else bg-gradient-info @endif text-white" href="{{ route('procurement_officer.orders.insurance.index',['order_id'=>$order->id]) }}">
            <i class="fa fa-file-alt">

            </i>
            تأمين
        </a>
        <a class="btn btn-app @if(!\App\Models\OrderClearanceModel::where('order_id',$order->id)->get()->isEmpty()) bg-gradient-success @else bg-gradient-info @endif text-white" href="{{ route('procurement_officer.orders.clearance.index',['order_id'=>$order->id]) }}">
            <i class="fa fa-file-import">

            </i>
            تخليص
        </a>
        <a class="btn btn-app @if(!\App\Models\OrderLocalDeliveryModel::where('order_id',$order->id)->get()->isEmpty()) bg-gradient-success @else bg-gradient-info @endif text-white" href="{{ route('procurement_officer.orders.delivery.index',['order_id'=>$order->id]) }}">
            <i class="fa fa-car">

            </i>
            توصيل
        </a>
        {{--    <a class="btn btn-app bg-gradient-info text-white" href="{{ route('procurement_officer.orders.calender.index',['order_id'=>$order->id]) }}">--}}
        {{--        <i class="fa fa-calendar">--}}

        {{--        </i>--}}
        {{--        تقويم--}}
        {{--    </a>--}}
        <a class="btn btn-app bg-gradient-info text-white" href="{{ route('procurement_officer.orders.attachment.index',['order_id'=>$order->id]) }}">
            <i class="fa fa-paperclip">

            </i>
            مرفقات
        </a>
        <a class="btn btn-app bg-gradient-info text-white" href="{{ route('procurement_officer.orders.notes.index',['order_id'=>$order->id]) }}">
            <i class="fa fa-note-sticky">

            </i>
            ملاحظات
        </a>
        <a class="btn btn-app bg-gradient-info text-white" href="{{ route('procurement_officer.orders.forms.index',['order_id'=>$order->id]) }}">
            <i class="fa fa-file-circle-check">

            </i>
            نماذج
        </a>
        <a class="btn btn-app bg-gradient-info text-white" href="{{ route('procurement_officer.orders.chat_message.index',['order_id'=>$order->id]) }}">
            <i class="fa fa-message">

            </i>
            محادثات
        </a>
        {{--    <a target="_blank" class="btn btn-app bg-gradient-info text-white" href="{{ route('procurement_officer.orders.forms.order_summery',['order_id'=>$order->id]) }}">--}}
        {{--        <i class="fa fa-file-circle-check">--}}

        {{--        </i>--}}
        {{--        ملخص الطلبية--}}
        {{--    </a>--}}
    </div>
@endif
