@php
    $jlUser = auth()->user();
    $jlRoleLabels = [
        1 => 'مدير النظام',
        2 => 'موظف المشتريات',
        3 => 'سكرتيريا',
        9 => 'أمين المستودع',
        11 => 'مدير الشحن',
    ];
    $jlRoleLabel = $jlRoleLabels[(int) $jlUser->user_role] ?? 'مستخدم';
    $jlInitial = mb_substr(trim((string) $jlUser->name), 0, 1) ?: '؟';
@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light" aria-label="الشريط العلوي">
    <ul class="navbar-nav align-items-center">
        <li class="nav-item">
            <a class="nav-link jl-icon-btn" data-widget="pushmenu" data-enable-remember="true" href="#" role="button"
               aria-label="إظهار أو إخفاء القائمة الجانبية" title="القائمة الجانبية">
                <i class="fas fa-bars" aria-hidden="true"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-flex">
            <div class="jl-navbar-title">
                <strong>{{ company_name }}</strong>
                <small>نظام إدارة المشتريات</small>
            </div>
        </li>
    </ul>

    <ul class="navbar-nav align-items-center jl-navbar-end">
        <li class="nav-item d-none d-md-block">
            <a class="nav-link jl-icon-btn" href="{{ route('home') }}" aria-label="الرئيسية" title="الرئيسية">
                <i class="fas fa-house" aria-hidden="true"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle jl-user-toggle" href="#" id="jl-user-menu" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="jl-avatar" aria-hidden="true">{{ $jlInitial }}</span>
                <span class="jl-user-meta d-none d-sm-flex">
                    <strong>{{ $jlUser->name }}</strong>
                    <small>{{ $jlRoleLabel }}</small>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right jl-user-menu" aria-labelledby="jl-user-menu">
                <div class="jl-user-menu__head">
                    <span class="jl-avatar jl-avatar--lg" aria-hidden="true">{{ $jlInitial }}</span>
                    <div class="jl-user-meta">
                        <strong>{{ $jlUser->name }}</strong>
                        <small>{{ $jlUser->email }}</small>
                    </div>
                </div>
                @if ((int) $jlUser->user_role == 9)
                    <a class="dropdown-item" href="{{ route('users.storekeeper.personal_account', ['id' => $jlUser->id]) }}">
                        <i class="fas fa-id-card fa-fw" aria-hidden="true"></i> الملف الشخصي
                    </a>
                @endif
                <a class="dropdown-item" href="{{ route('home') }}">
                    <i class="fas fa-gauge-high fa-fw" aria-hidden="true"></i> لوحة التحكم
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fas fa-right-from-bracket fa-fw" aria-hidden="true"></i> تسجيل الخروج
                </a>
            </div>
        </li>
    </ul>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        {{ csrf_field() }}
    </form>
</nav>
