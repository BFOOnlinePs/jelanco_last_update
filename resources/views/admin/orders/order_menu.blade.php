@php
    $jlOrderRoute = fn (string $section) => route('procurement_officer.orders.' . $section . '.index', ['order_id' => $order->id]);
    $jlIsHere = fn (string $section) => request()->routeIs('procurement_officer.orders.' . $section . '.*');

    // مراحل الطلبية بالترتيب، والمرحلة "مكتملة" اذا فيها بيانات
    $jlSteps = [
        ['label' => 'الأصناف', 'section' => 'product',
            'done' => \App\Models\OrderItemsModel::where('order_id', $order->id)->exists()],
        ['label' => 'عروض الأسعار', 'section' => 'price_offer',
            'done' => \App\Models\PriceOffersModel::where('order_id', $order->id)->exists()],
        ['label' => 'الترسية', 'section' => 'anchor',
            'done' => \App\Models\PriceOffersModel::where('order_id', $order->id)->where('status', 1)->exists()],
        ['label' => 'الملف المالي', 'section' => 'financial_file',
            'done' => \App\Models\CashPaymentsModel::where('order_id', $order->id)->exists()
                || \App\Models\LetterBankModel::where('order_id', $order->id)->exists()],
        ['label' => 'الشحن', 'section' => 'shipping',
            'done' => \App\Models\ShippingPriceOfferModel::where('order_id', $order->id)->exists()],
        ['label' => 'التأمين', 'section' => 'insurance',
            'done' => \App\Models\OrderInsuranceModel::where('order_id', $order->id)->exists()],
        ['label' => 'التخليص', 'section' => 'clearance',
            'done' => \App\Models\OrderClearanceModel::where('order_id', $order->id)->exists()],
        ['label' => 'التوصيل', 'section' => 'delivery',
            'done' => \App\Models\OrderLocalDeliveryModel::where('order_id', $order->id)->exists()],
    ];

    $jlTools = [
        ['label' => 'المرفقات', 'icon' => 'fa-paperclip', 'section' => 'attachment'],
        ['label' => 'الملاحظات', 'icon' => 'fa-note-sticky', 'section' => 'notes'],
        ['label' => 'النماذج', 'icon' => 'fa-file-circle-check', 'section' => 'forms'],
        ['label' => 'المحادثات', 'icon' => 'fa-comments', 'section' => 'chat_message'],
    ];

    // مدير الشحن يرى مرحلة الشحن فقط
    if (auth()->user()->user_role == 11) {
        $jlSteps = array_values(array_filter($jlSteps, fn ($step) => $step['section'] === 'shipping'));
        $jlTools = [];
    }
@endphp

<nav class="jl-order-nav" aria-label="مراحل الطلبية">
    <span class="jl-order-nav__label" id="jl-order-steps-label">مراحل الطلبية</span>
    <ol class="jl-steps" aria-labelledby="jl-order-steps-label">
        @foreach ($jlSteps as $jlStep)
            @php
                $jlCurrent = $jlIsHere($jlStep['section']);
            @endphp
            <li>
                <a href="{{ $jlOrderRoute($jlStep['section']) }}"
                   class="jl-step {{ $jlStep['done'] ? 'is-done' : '' }} {{ $jlCurrent ? 'is-current' : '' }}"
                   @if ($jlCurrent) aria-current="page" @endif>
                    <span class="jl-step__num" aria-hidden="true">
                        @if ($jlStep['done'])
                            <i class="fas fa-check"></i>
                        @else
                            {{ $loop->iteration }}
                        @endif
                    </span>
                    {{ $jlStep['label'] }}
                    @if ($jlStep['done'])
                        <span class="sr-only">(تحتوي على بيانات)</span>
                    @endif
                </a>
            </li>
        @endforeach
    </ol>

    @if (!empty($jlTools))
        <div class="jl-order-nav__tools">
            @foreach ($jlTools as $jlTool)
                @php
                    $jlCurrent = $jlIsHere($jlTool['section']);
                @endphp
                <a href="{{ $jlOrderRoute($jlTool['section']) }}" class="jl-tool {{ $jlCurrent ? 'is-current' : '' }}"
                   @if ($jlCurrent) aria-current="page" @endif>
                    <i class="fas {{ $jlTool['icon'] }}" aria-hidden="true"></i> {{ $jlTool['label'] }}
                </a>
            @endforeach
            <button type="button" class="jl-tool border-0" onclick="fetchActivityLogs({{ $order->id }})">
                <i class="fas fa-clock-rotate-left" aria-hidden="true"></i> سجل النشاطات
            </button>
        </div>
    @endif
</nav>

    <!-- Activity Log Modal -->
    <div class="modal fade" id="modal-activity_log" tabindex="-1" role="dialog" aria-labelledby="modal-activity_log-title" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-activity_log-title">سجل نشاطات الطلبية</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function fetchActivityLogs(orderId) {
        $('#modal-activity_log').modal('show');
        $('#activity_log_body').html('<tr><td colspan="4" class="text-center">يتم التحميل...</td></tr>');
        
        $.ajax({
            // يجب استخدام route وليس مسار ثابت، حتى يعمل الرابط إذا كان
            // المشروع منصّباً داخل مجلد فرعي على السيرفر.
            url: '{{ route('orders.activity_logs.get', ['order_id' => '__ORDER_ID__']) }}'.replace('__ORDER_ID__', orderId),
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
            error: function(xhr) {
                var reason = xhr.status === 419 || xhr.status === 401
                    ? 'انتهت صلاحية الجلسة، يرجى تسجيل الدخول من جديد'
                    : 'رمز الخطأ: ' + xhr.status;
                $('#activity_log_body').html('<tr><td colspan="4" class="text-danger">حدث خطأ أثناء جلب البيانات (' + reason + ')</td></tr>');
            }
        });
    }
    </script>
