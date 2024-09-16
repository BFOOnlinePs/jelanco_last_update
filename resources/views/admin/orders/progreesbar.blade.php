<style>
    .step-progress {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 50%;
        height: 80px;
    }
    .step-line {
        position: absolute;
        width: 100%;
        height: 1px;
        background-color: #6c757d;
        top: 50%;
        transform: translateY(-50%);
        z-index: -1;
    }
    .step-circle {
        width: 60px;
        height: 60px;
        line-height: 60px;
        border: 2px solid #6c757d;
        border-radius: 50%;
        background-color: #fff;
        font-weight: bold;
        font-size: 10px;
        color: #6c757d;
        text-align: center;
        position: relative; /* Add this */

    }
    .active-circle {
        background-color: #5cb85c;
        color: white;
    }
</style>
<div class="container mb-3 d-flex justify-content-center">
    <div class="step-progress">
        <div class="step-line"></div>
        <div class="step-circle @if(!\App\Models\OrderItemsModel::where('order_id',$order->id)->get()->isEmpty()) active-circle @endif">اصناف</div>
        <div class="step-circle @if(!\App\Models\PriceOffersModel::where('order_id',$order->id)->get()->isEmpty()) active-circle @endif">عروض</div>
        <div class="step-circle @if(!\App\Models\PriceOffersModel::where('order_id',$order->id)->where('status',1)->get()->isEmpty()) active-circle @endif">ترسية</div>
        <div class="step-circle @if((!\App\Models\CashPaymentsModel::where('order_id',$order->id)->get()->isEmpty()) || (!\App\Models\LetterBankModel::where('order_id',$order->id)->get()->isEmpty())) active-circle @endif">ملف مالي</div>
        <div class="step-circle @if(!\App\Models\ShippingPriceOfferModel::where('order_id',$order->id)->get()->isEmpty()) active-circle @endif">شحن</div>
        <div class="step-circle @if(!\App\Models\OrderInsuranceModel::where('order_id',$order->id)->get()->isEmpty()) active-circle @endif">تأمين</div>
        <div class="step-circle @if(!\App\Models\OrderClearanceModel::where('order_id',$order->id)->get()->isEmpty()) active-circle @endif">تخليص</div>
        <div class="step-circle @if(!\App\Models\OrderLocalDeliveryModel::where('order_id',$order->id)->get()->isEmpty()) active-circle @endif">توصيل</div>
{{--        <div class="step-circle @if(!$product->isEmpty()) active-circle @endif">تقويم</div>--}}
{{--        <div class="step-circle @if(!\App\Models\OrderAttachmentModel::where('order_id',$order->id)->get()->isEmpty()) active-circle @endif">مرفقات</div>--}}
{{--        <div class="step-circle @if(!\App\Models\OrderAttachmentModel::where('order_id',$order->id)->get()->isEmpty()) active-circle @endif">ملاحظات</div>--}}
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
