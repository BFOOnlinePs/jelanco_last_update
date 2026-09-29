@extends('home')
@section('title')
    الإعدادات
@endsection
@section('header_title')
    الإعدادات
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    الإعدادات
@endsection
@section('content')
    @php
        $jlGroups = [
            'المالية' => [
                ['العملات', 'العملات وأسعار الصرف', 'fa-coins', 'currency.index'],
                ['البنوك', 'البنوك المعتمدة للدفع', 'fa-building-columns', 'bank.index'],
                ['عناصر تقدير التكلفة', 'بنود احتساب تكلفة الطلبية', 'fa-calculator', 'estimation_cost_element.index'],
            ],
            'الطلبيات والشحن' => [
                ['حالة الطلبيات', 'مراحل وحالات الطلبية', 'fa-stamp', 'order_status.index'],
                ['طرق الشحن', 'بحري، جوي، بري...', 'fa-truck-fast', 'shipping_methods.index'],
                ['مرفقات التخليص', 'المستندات المطلوبة للتخليص', 'fa-file-lines', 'clearance_attachment.index'],
                ['معايير التقييم', 'معايير تقييم الطلبيات والموردين', 'fa-star-half-stroke', 'criteria.index'],
            ],
            'النظام' => [
                ['أنواع المهام', 'تصنيف المهام', 'fa-list-check', 'tasks_type.index'],
                ['مجالات الاختصاص', 'مجالات عمل الموردين', 'fa-tags', 'setting.user_category.index'],
                ['إعدادات النظام', 'المظهر والإعدادات العامة', 'fa-sliders', 'setting.system_setting.index'],
            ],
        ];
    @endphp

    @foreach ($jlGroups as $jlGroupTitle => $jlTiles)
        <h2 class="jl-section-title">{{ $jlGroupTitle }}</h2>
        <div class="row">
            @foreach ($jlTiles as [$jlTitle, $jlDesc, $jlIcon, $jlRoute])
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <a href="{{ route($jlRoute) }}" class="jl-tile">
                        <span class="jl-tile__icon" aria-hidden="true"><i class="fas {{ $jlIcon }}"></i></span>
                        <span class="jl-tile__body">
                            <span class="jl-tile__title">{{ $jlTitle }}</span>
                            <span class="jl-tile__desc">{{ $jlDesc }}</span>
                        </span>
                    </a>
                </div>
            @endforeach
        </div>
    @endforeach
@endsection
