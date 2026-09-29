@extends('home')
@section('title')
    المستخدمين
@endsection
@section('header_title')
    المستخدمين
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    المستخدمين
@endsection
@section('content')
    @php
        $jlGroups = [
            'فريق العمل' => [
                ['موظفو المشتريات', 'متابعة الطلبيات وعروض الأسعار', 'fa-user-tie', 'users.procurement_officer.index'],
                ['أمناء المستودع', 'طلبات الشراء من المستودع', 'fa-warehouse', 'users.storekeeper.index'],
                ['السكرتيريا', 'حسابات السكرتيريا', 'fa-user-pen', 'users.secretarial.index'],
                ['مدراء الشحن', 'متابعة مراحل الشحن', 'fa-user-gear', 'users.shipping_manager.index'],
            ],
            'الموردون والشركاء' => [
                ['الموردين', 'بيانات الموردين وجهات الاتصال', 'fa-truck-field', 'users.supplier.index'],
                ['شركات الشحن', 'الشحن الدولي', 'fa-ship', 'users.delivery_company.index'],
                ['شركات التخليص', 'التخليص الجمركي', 'fa-file-import', 'users.clearance_companies.index'],
                ['شركات النقل المحلي', 'التوصيل داخل البلد', 'fa-truck', 'users.local_carriers.index'],
                ['شركات التأمين', 'تأمين الشحنات', 'fa-shield-halved', 'users.insurance_companies.index'],
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
