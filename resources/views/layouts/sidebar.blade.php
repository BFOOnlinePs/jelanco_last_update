@php
    $jlRole = (int) auth()->user()->user_role;

    // لون القائمة الجانبية من اعدادات النظام (اختياري)
    $jlSidebarColor = optional(App\Models\SystemSettingModel::first())->sidebar_color;
    $jlSidebarColor = preg_match('/^#[0-9a-fA-F]{3,8}$/', (string) $jlSidebarColor) ? $jlSidebarColor : null;

    $jlItem = fn (string $label, string $icon, string $url, array $patterns = []) => compact('label', 'icon', 'url', 'patterns');

    $jlDashboard = $jlItem('لوحة التحكم', 'fa-gauge-high', route('home'), ['home']);
    $jlOrders = $jlItem('طلبات الشراء', 'fa-cart-shopping', route('orders.procurement_officer.order_index'), [
        'orders.procurement_officer.order_index', 'orders.procurement_officer.list_orders_from_storekeeper',
        'orders.procurement_officer.order_items_index', 'procurement_officer.orders.*', 'order_archive.*', 'trash.*',
    ]);
    $jlEvaluation = $jlItem('تقييم الطلبات', 'fa-star-half-stroke', route('evaluation.index'), ['evaluation.*']);
    $jlSuppliers = $jlItem('الموردين', 'fa-truck-field', route('users.supplier.index'), ['users.supplier.*', 'company_contact_person.*']);
    $jlMessages = $jlItem('الرسائل', 'fa-comments', route('message.send_message_page'), ['message.*']);
    $jlCalendar = $jlItem('التقويم', 'fa-calendar-days', route('calendar.index'), ['calendar.*']);
    $jlNotebook = $jlItem('دفتر ملاحظاتي', 'fa-note-sticky', route('note_book.index'), ['note_book.*']);
    $jlReports = $jlItem('التقارير', 'fa-chart-column', route('reports.index'), ['reports.*']);
    $jlSettings = $jlItem('الإعدادات', 'fa-gear', route('setting.index'), [
        'setting.*', 'currency.*', 'bank.*', 'tasks_type.*', 'shipping_methods.*', 'clearance_attachment.*',
        'estimation_cost_element.*', 'order_status.*', 'criteria.*',
    ]);
    $jlOfficerTasks = $jlItem('المهام', 'fa-list-check', route('procurement_officer.tasks.index'), ['procurement_officer.tasks.*']);
    $jlProductsHub = $jlItem('الأصناف', 'fa-boxes-stacked', route('product.home'), ['product.*', 'units.*', 'category.*']);

    $jlMenu = match ($jlRole) {
        // أمين المستودع
        9 => [
            null => [$jlDashboard, $jlItem('الملف الشخصي', 'fa-id-card', route('users.storekeeper.personal_account', ['id' => auth()->user()->id]), ['users.storekeeper.personal_account'])],
            'طلبات الشراء' => [
                $jlItem('طلبات الشراء بواسطتي', 'fa-cart-plus', route('orders.index'), ['orders.index', 'orders.order_items']),
                $jlItem('جميع طلبات الشراء', 'fa-clipboard-list', route('users.storekeeper.orders.index'), ['users.storekeeper.orders.*']),
                $jlEvaluation,
            ],
            'التواصل والمتابعة' => [$jlMessages, $jlOfficerTasks],
        ],
        // موظف المشتريات
        2 => [
            null => [$jlDashboard],
            'المشتريات' => [
                $jlOrders,
                $jlItem('طلباتي', 'fa-user-check', route('orders.procurement_officer.listOrderForOfficerIndex'), ['orders.procurement_officer.listOrderForOfficerIndex']),
                $jlProductsHub,
                $jlSuppliers,
                $jlEvaluation,
            ],
            'التواصل والمتابعة' => [$jlMessages, $jlOfficerTasks, $jlCalendar, $jlNotebook],
            'الإدارة' => [$jlReports, $jlSettings],
        ],
        // سكرتيريا
        3 => [
            null => [$jlDashboard],
            'المشتريات' => [$jlOrders, $jlProductsHub, $jlSuppliers],
            'التواصل والمتابعة' => [$jlCalendar],
        ],
        // مدير الشحن
        11 => [
            null => [$jlDashboard],
            'المشتريات' => [$jlOrders],
        ],
        // مدير النظام
        default => [
            null => [$jlDashboard],
            'المشتريات' => [
                $jlOrders,
                $jlItem('الأصناف', 'fa-boxes-stacked', route('product.index'), ['product.*', 'units.*', 'category.*']),
                $jlEvaluation,
            ],
            'التواصل والمتابعة' => [
                $jlItem('المهام', 'fa-list-check', route('tasks.index'), ['tasks.*']),
                $jlCalendar,
                $jlMessages,
                $jlNotebook,
            ],
            'الإدارة' => [
                $jlItem('المستخدمين', 'fa-users', route('users.index'), ['users.*', 'company_contact_person.*']),
                $jlReports,
                $jlSettings,
            ],
        ],
    };
@endphp
<aside class="main-sidebar jl-sidebar sidebar-dark-primary"
       @if ($jlSidebarColor) style="--jl-sidebar-bg: {{ $jlSidebarColor }}" @endif>
    <a href="{{ route('home') }}" class="brand-link" aria-label="{{ company_name }} - الرئيسية">
        <span class="jl-brand__logo"><img src="{{ asset('img/jelanco.png') }}" alt=""></span>
        <span class="brand-text jl-brand__text">
            <strong>{{ company_name }}</strong>
            <small>نظام إدارة المشتريات</small>
        </span>
    </a>

    <div class="sidebar">
        <nav aria-label="القائمة الرئيسية">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" data-accordion="false">
                @foreach ($jlMenu as $jlSection => $jlItems)
                    @if ($jlSection)
                        <li class="nav-header">{{ $jlSection }}</li>
                    @endif
                    @foreach ($jlItems as $jlLink)
                        @php
                            $jlActive = $jlLink['patterns'] && request()->routeIs(...$jlLink['patterns']);
                        @endphp
                        <li class="nav-item">
                            <a href="{{ $jlLink['url'] }}" class="nav-link {{ $jlActive ? 'active' : '' }}"
                               @if ($jlActive) aria-current="page" @endif title="{{ $jlLink['label'] }}">
                                <i class="nav-icon fas {{ $jlLink['icon'] }}" aria-hidden="true"></i>
                                <p>{{ $jlLink['label'] }}</p>
                            </a>
                        </li>
                    @endforeach
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
