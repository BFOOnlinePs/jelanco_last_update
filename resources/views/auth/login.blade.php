@php
    $jlLogo = App\Models\SystemSettingModel::logoUrl();

    // لوحة الشعار تأخذ لون القائمة الجانبية من اعدادات النظام إن وُجد
    $jlBrandColor = optional(App\Models\SystemSettingModel::current())->sidebar_color;
    $jlBrandColor = preg_match('/^#[0-9a-fA-F]{3,8}$/', (string) $jlBrandColor) ? $jlBrandColor : null;
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0f1b3d">
    <title>تسجيل الدخول | {{ company_name }}</title>
    <link rel="icon" href="{{ $jlLogo }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap_rtl-v4.2.1/bootstrap.min.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

    @include('layouts.theme')

    <style>
        body {
            margin: 0;
            background: var(--jl-surface);
        }

        .jl-login {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ===== نصف بيانات الدخول ===== */
        .jl-login__form-side {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 32px;
            background: var(--jl-surface);
        }

        .jl-login__form-wrap {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .jl-login__mobile-logo {
            display: none;
        }

        .jl-login__title {
            margin: 0 0 .35rem;
            color: var(--jl-text);
            font-size: 1.85rem;
            font-weight: 800;
        }

        .jl-login__subtitle {
            margin: 0 0 2rem;
            color: var(--jl-muted);
            font-size: .98rem;
        }

        .jl-login label {
            margin-bottom: .4rem;
            color: var(--jl-text-2);
            font-size: .9rem;
            font-weight: 700;
        }

        .jl-login__field {
            position: relative;
        }

        .jl-login__field > .jl-login__icon {
            position: absolute;
            top: 50%;
            right: 16px;
            transform: translateY(-50%);
            color: var(--jl-muted);
            pointer-events: none;
            transition: color .15s ease;
        }

        .jl-login__field .form-control {
            height: 50px;
            padding: 0 46px 0 46px;
            background: var(--jl-surface-2);
            border: 1px solid var(--jl-border-strong);
            border-radius: var(--jl-radius);
            font-size: 1rem;
            text-align: right;
            transition: border-color .15s ease, box-shadow .15s ease, background-color .15s ease;
        }

        .jl-login__field .form-control::placeholder {
            color: #94a3b8;
        }

        .jl-login__field .form-control:focus {
            background: var(--jl-surface);
            border-color: var(--jl-primary);
            box-shadow: var(--jl-focus);
        }

        .jl-login__field:focus-within > .jl-login__icon {
            color: var(--jl-primary);
        }

        .jl-login__field .form-control.is-invalid {
            border-color: var(--jl-danger);
            background-image: none;
        }

        .jl-login__toggle {
            position: absolute;
            top: 50%;
            left: 6px;
            transform: translateY(-50%);
            width: 38px;
            height: 38px;
            padding: 0;
            color: var(--jl-muted);
            background: transparent;
            border: 0;
            border-radius: var(--jl-radius-sm);
            cursor: pointer;
        }

        .jl-login__toggle:hover {
            color: var(--jl-primary);
            background: var(--jl-primary-50);
        }

        .jl-login__toggle:focus-visible {
            outline: 0;
            box-shadow: var(--jl-focus);
        }

        .jl-login__error {
            display: flex;
            align-items: center;
            gap: .4rem;
            margin-top: .45rem;
            color: var(--jl-danger);
            font-size: .85rem;
            font-weight: 500;
        }

        .jl-login__submit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;
            width: 100%;
            height: 50px;
            margin-top: 1.75rem;
            font-size: 1.02rem;
            font-weight: 700;
            border-radius: var(--jl-radius);
        }

        .jl-login__submit .fa-arrow-left {
            transition: transform .15s ease;
        }

        .jl-login__submit:hover .fa-arrow-left {
            transform: translateX(-3px);
        }

        .jl-login__submit .jl-login__spinner {
            display: none;
        }

        .jl-login__submit.is-loading .jl-login__spinner {
            display: inline-block;
        }

        .jl-login__submit.is-loading .fa-arrow-left {
            display: none;
        }

        .jl-login__copy {
            margin: 2.5rem 0 0;
            color: var(--jl-muted);
            font-size: .8rem;
            text-align: center;
        }

        /* ===== نصف شعار الشركة ===== */
        .jl-login__brand {
            --jl-login-brand: var(--jl-sidebar-bg);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            overflow: hidden;
            color: #fff;
            background-color: var(--jl-login-brand);
            background:
                radial-gradient(circle at 1px 1px, rgba(255, 255, 255, .07) 1px, transparent 0) 0 0 / 22px 22px,
                linear-gradient(150deg, var(--jl-login-brand) 0%, color-mix(in srgb, var(--jl-login-brand) 62%, #000) 100%);
        }

        .jl-login__brand::before,
        .jl-login__brand::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .jl-login__brand::before {
            top: -160px;
            left: -140px;
            width: 460px;
            height: 460px;
            background: radial-gradient(circle, rgba(255, 255, 255, .14), transparent 70%);
        }

        .jl-login__brand::after {
            right: -120px;
            bottom: -150px;
            width: 420px;
            height: 420px;
            background: radial-gradient(circle, rgba(215, 25, 32, .28), transparent 70%);
        }

        .jl-login__brand-inner {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 440px;
            text-align: center;
        }

        .jl-login__logo-plate {
            display: flex;
            align-items: center;
            justify-content: center;
            width: min(320px, 70vw);
            aspect-ratio: 1;
            padding: 36px;
            background: #fff;
            border-radius: 28px;
            box-shadow: 0 30px 70px rgba(0, 0, 0, .35), 0 0 0 10px rgba(255, 255, 255, .06);
        }

        .jl-login__logo-plate img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .jl-login__brand-name {
            margin: 2.25rem 0 .5rem;
            color: #fff;
            font-size: 1.85rem;
            font-weight: 800;
        }

        .jl-login__brand-line {
            width: 48px;
            height: 4px;
            margin-bottom: .9rem;
            background: var(--jl-accent);
            border-radius: 4px;
        }

        .jl-login__brand-tagline {
            margin: 0;
            color: rgba(255, 255, 255, .75);
            font-size: 1.05rem;
        }

        /* ===== الشاشات الصغيرة: عمود واحد والشعار أعلى النموذج ===== */
        @media (max-width: 991.98px) {
            .jl-login {
                grid-template-columns: 1fr;
            }

            .jl-login__brand {
                display: none;
            }

            .jl-login__form-side {
                padding: 40px 20px;
            }

            .jl-login__mobile-logo {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 96px;
                height: 96px;
                margin: 0 auto 1.5rem;
                padding: 12px;
                background: #fff;
                border: 1px solid var(--jl-border);
                border-radius: 22px;
                box-shadow: var(--jl-shadow-lg);
            }

            .jl-login__mobile-logo img {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
            }

            .jl-login__title,
            .jl-login__subtitle {
                text-align: center;
            }
        }
    </style>
</head>
<body>
<main class="jl-login">
    <section class="jl-login__form-side">
        <div class="jl-login__form-wrap">
            <div class="jl-login__mobile-logo">
                <img src="{{ $jlLogo }}" alt="{{ company_name }}">
            </div>

            <h1 class="jl-login__title">تسجيل الدخول</h1>
            <p class="jl-login__subtitle">أهلاً بك، أدخل بيانات حسابك للمتابعة</p>

            <form id="login_form" action="{{ route('login') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <div class="jl-login__field">
                        <span class="jl-login__icon fas fa-envelope" aria-hidden="true"></span>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" dir="ltr"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="name@company.com" autocomplete="username" required autofocus
                               @error('email') aria-invalid="true" aria-describedby="email_error" @enderror>
                    </div>
                    @error('email')
                        <div id="email_error" class="jl-login__error" role="alert">
                            <span class="fas fa-circle-exclamation" aria-hidden="true"></span>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <label for="password">كلمة المرور</label>
                    <div class="jl-login__field">
                        <span class="jl-login__icon fas fa-lock" aria-hidden="true"></span>
                        <input id="password" name="password" type="password" dir="ltr"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••" autocomplete="current-password" required
                               @error('password') aria-invalid="true" aria-describedby="password_error" @enderror>
                        <button type="button" class="jl-login__toggle" id="toggle_password"
                                aria-label="إظهار كلمة المرور" aria-pressed="false">
                            <span class="fas fa-eye" aria-hidden="true"></span>
                        </button>
                    </div>
                    @error('password')
                        <div id="password_error" class="jl-login__error" role="alert">
                            <span class="fas fa-circle-exclamation" aria-hidden="true"></span>{{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary jl-login__submit" id="login_submit">
                    <span class="spinner-border spinner-border-sm jl-login__spinner" aria-hidden="true"></span>
                    <span>تسجيل الدخول</span>
                    <span class="fas fa-arrow-left" aria-hidden="true"></span>
                </button>
            </form>

            <p class="jl-login__copy">© {{ date('Y') }} {{ company_name }} · نظام إدارة المشتريات</p>
        </div>
    </section>

    <aside class="jl-login__brand" @if ($jlBrandColor) style="--jl-login-brand: {{ $jlBrandColor }}" @endif>
        <div class="jl-login__brand-inner">
            <div class="jl-login__logo-plate">
                <img src="{{ $jlLogo }}" alt="{{ company_name }}">
            </div>
            <h2 class="jl-login__brand-name">{{ company_name }}</h2>
            <span class="jl-login__brand-line" aria-hidden="true"></span>
            <p class="jl-login__brand-tagline">نظام إدارة المشتريات</p>
        </div>
    </aside>
</main>

<script>
    (function () {
        var password = document.getElementById('password');
        var toggle = document.getElementById('toggle_password');

        toggle.addEventListener('click', function () {
            var show = password.type === 'password';
            password.type = show ? 'text' : 'password';
            toggle.setAttribute('aria-pressed', show ? 'true' : 'false');
            toggle.setAttribute('aria-label', show ? 'إخفاء كلمة المرور' : 'إظهار كلمة المرور');
            toggle.firstElementChild.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
            password.focus();
        });

        // منع الإرسال المزدوج وإظهار مؤشر التحميل
        var submit = document.getElementById('login_submit');
        document.getElementById('login_form').addEventListener('submit', function () {
            submit.classList.add('is-loading');
            submit.disabled = true;
        });

        // عند الرجوع للصفحة من سجل المتصفح يعود الزر لحالته الطبيعية
        window.addEventListener('pageshow', function () {
            submit.classList.remove('is-loading');
            submit.disabled = false;
        });
    })();
</script>
</body>
</html>
