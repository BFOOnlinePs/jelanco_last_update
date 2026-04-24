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
        <a class="btn btn-app bg-gradient-info text-white" onclick="fetchActivityLogs({{ $order->id }})">
            <i class="fa fa-history"></i>
            سجل النشاطات
        </a>
        {{--    <a target="_blank" class="btn btn-app bg-gradient-info text-white" href="{{ route('procurement_officer.orders.forms.order_summery',['order_id'=>$order->id]) }}">--}}
        {{--        <i class="fa fa-file-circle-check">--}}

        {{--        </i>--}}
        {{--        ملخص الطلبية--}}
        {{--    </a>--}}
    </div>
@endif

    <!-- Activity Log Modal -->
    <div class="modal fade" id="modal-activity_log">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title text-white">سجل نشاطات الطلبية</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>النشاط</th>
                                    <th>الموظف</th>
                                    <th>التفاصيل</th>
                                    <th>التاريخ والوقت</th>
                                </tr>
                            </thead>
                            <tbody id="activity_log_body">
                                <tr><td colspan="4" class="text-center">يتم التحميل...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function fetchActivityLogs(orderId) {
        $('#modal-activity_log').modal('show');
        $('#activity_log_body').html('<tr><td colspan="4" class="text-center">يتم التحميل...</td></tr>');
        
        $.ajax({
            url: '/orders/get-activity-logs/' + orderId,
            method: 'GET',
            success: function(response) {
                let html = '';
                if(response.length === 0) {
                    html = '<tr><td colspan="4">لا توجد سجلات. تفاعل مع الطلبية أولاً</td></tr>';
                } else {
                    response.forEach(function(log) {
                        let details = log.description || '';
                        if (log.old_value !== null || log.new_value !== null) {
                            let oldVal = log.old_value !== null ? String(log.old_value).replace(/\n/g, '<br>') : 'فارغ';
                            let newVal = log.new_value !== null ? String(log.new_value).replace(/\n/g, '<br>') : 'فارغ';
                            details += `<div class="mt-1" style="font-size: 11px; padding: 5px; background: #f8f9fa; border-radius: 4px; border: 1px solid #ddd;">
                                <span class="text-danger"><strong>القديمة:</strong> ${oldVal}</span> 
                                <i class="fa fa-arrow-left mx-1 text-muted"></i> 
                                <span class="text-success"><strong>الجديدة:</strong> ${newVal}</span>
                            </div>`;
                        }
                        html += `<tr>
                            <td>${log.action}</td>
                            <td>${log.user}</td>
                            <td>${details}</td>
                            <td style="direction: ltr;">${log.created_at}</td>
                        </tr>`;
                    });
                }
                $('#activity_log_body').html(html);
            },
            error: function() {
                $('#activity_log_body').html('<tr><td colspan="4" class="text-danger">حدث خطأ أثناء جلب البيانات</td></tr>');
            }
        });
    }
    </script>
