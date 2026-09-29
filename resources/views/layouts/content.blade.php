@php
    $jlTitle = trim($__env->yieldContent('header_title'));
    $jlParent = trim(strip_tags($__env->yieldContent('header_link')));
    $jlCurrent = trim(strip_tags($__env->yieldContent('header_title_link'))) ?: trim(strip_tags($jlTitle));

    // روابط الصفحات الأب المعروفة في مسار التنقل
    $jlParentRoutes = [
        'المستخدمين' => 'users.index',
        'الاعدادات' => 'setting.index',
        'الإعدادات' => 'setting.index',
        'الموردين' => 'users.supplier.index',
        'ادارة الموردين' => 'users.supplier.index',
        'دفتر الملاحظات' => 'note_book.index',
        'التقارير' => 'reports.index',
    ];
    if ((int) auth()->user()->user_role != 9) {
        foreach (['طلبات الشراء', 'ادارة طلبات الشراء', 'طلبيات شراء', 'الطلبيات', 'الطلبات'] as $jlOrdersLabel) {
            $jlParentRoutes[$jlOrdersLabel] = 'orders.procurement_officer.order_index';
        }
    }
    $jlParentUrl = isset($jlParentRoutes[$jlParent]) ? route($jlParentRoutes[$jlParent]) : null;
    $jlShowParent = $jlParent !== '' && $jlParent !== 'الرئيسية' && $jlParent !== $jlCurrent;
@endphp
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="jl-page-header">
                <h1>{!! $jlTitle !!}</h1>
                <nav aria-label="مسار التنقل">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" title="الرئيسية">
                                <i class="fas fa-house" aria-hidden="true"></i><span class="sr-only">الرئيسية</span>
                            </a>
                        </li>
                        @if ($jlShowParent)
                            <li class="breadcrumb-item">
                                @if ($jlParentUrl)
                                    <a href="{{ $jlParentUrl }}">{{ $jlParent }}</a>
                                @else
                                    {{ $jlParent }}
                                @endif
                            </li>
                        @endif
                        @if ($jlCurrent !== '')
                            <li class="breadcrumb-item active" aria-current="page">{{ $jlCurrent }}</li>
                        @endif
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <main id="main-content" class="content" tabindex="-1">
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>
</div>
