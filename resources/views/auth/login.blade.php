
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل الدخول</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css?v=3.2.0') }}">

{{--    <link rel="preconnect" href="https://fonts.googleapis.com">--}}
{{--    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>--}}
{{--    <link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet">--}}

{{--    <link rel="stylesheet" href="{{ asset('assets/fonts/Tajawal/Tajawal-Regular.ttf') }}">--}}

    <style>
        @font-face {
            font-family: TajawalRegular;
            src: url('public/assets/fonts/Tajawal/Tajawal-Regular.ttf') format('truetype');
        }

        * {
            font-family: 'Tajawal', sans-serif;
        }
    </style>

    <script nonce="c56c3e82-46a3-4556-86b9-28eb8519800f">(function(w,d){!function(bg,bh,bi,bj){bg[bi]=bg[bi]||{};bg[bi].executed=[];bg.zaraz={deferred:[],listeners:[]};bg.zaraz.q=[];bg.zaraz._f=function(bk){return function(){var bl=Array.prototype.slice.call(arguments);bg.zaraz.q.push({m:bk,a:bl})}};for(const bm of["track","set","debug"])bg.zaraz[bm]=bg.zaraz._f(bm);bg.zaraz.init=()=>{var bn=bh.getElementsByTagName(bj)[0],bo=bh.createElement(bj),bp=bh.getElementsByTagName("title")[0];bp&&(bg[bi].t=bh.getElementsByTagName("title")[0].text);bg[bi].x=Math.random();bg[bi].w=bg.screen.width;bg[bi].h=bg.screen.height;bg[bi].j=bg.innerHeight;bg[bi].e=bg.innerWidth;bg[bi].l=bg.location.href;bg[bi].r=bh.referrer;bg[bi].k=bg.screen.colorDepth;bg[bi].n=bh.characterSet;bg[bi].o=(new Date).getTimezoneOffset();if(bg.dataLayer)for(const bt of Object.entries(Object.entries(dataLayer).reduce(((bu,bv)=>({...bu[1],...bv[1]})),{})))zaraz.set(bt[0],bt[1],{scope:"page"});bg[bi].q=[];for(;bg.zaraz.q.length;){const bw=bg.zaraz.q.shift();bg[bi].q.push(bw)}bo.defer=!0;for(const bx of[localStorage,sessionStorage])Object.keys(bx||{}).filter((bz=>bz.startsWith("_zaraz_"))).forEach((by=>{try{bg[bi]["z_"+by.slice(7)]=JSON.parse(bx.getItem(by))}catch{bg[bi]["z_"+by.slice(7)]=bx.getItem(by)}}));bo.referrerPolicy="origin";bo.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(bg[bi])));bn.parentNode.insertBefore(bo,bn)};["complete","interactive"].includes(bh.readyState)?zaraz.init():bg.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document);</script></head>
<body class="hold-transition login-page">
<div class="login-box">

    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="{{ asset('assets/index2.html') }}" class="h1"><b>Jelanco</b></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">ابدا بتسجيل الدخول من هنا</p>
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="input-group ">
                    <input name="email" type="email" id="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>

                </div>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                <div class="input-group mt-3">
                    <input name="password" type="password" id="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                @error('password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
{{--                <div class="div pt-2">--}}
{{--                    <div class="div p-1 ">--}}
{{--                        <button onclick="login('admin@admin.com','123456789')" type="button" class="btn btn-dark btn-sm form-control">ادمن</button>--}}
{{--                    </div>--}}
{{--                    <div class="div p-1">--}}
{{--                        <button onclick="login('salesman@mail.com','123456789')"  type="button" class="btn btn-dark btn-sm form-control">موظف مشتريات</button>--}}
{{--                    </div>--}}
{{--                    <div class="div p-1">--}}
{{--                        <button onclick="login('storekeeper@mail.com','123456789')"  type="button" class="btn btn-dark btn-sm form-control">امين مستودع</button>--}}
{{--                    </div>--}}
{{--                    <div class="div p-1">--}}
{{--                        <button onclick="login('secretarial@mail.com','123456789')"  type="button" class="btn btn-dark btn-sm form-control">سكرتيريا</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="row mt-3">
{{--                    <div class="col-8">--}}
{{--                        <div class="icheck-primary">--}}
{{--                            <input type="checkbox" id="remember">--}}
{{--                            <label for="remember">--}}
{{--                                Remember Me--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="col">
                        <button type="submit" class="btn btn-dark btn-block">تسجيل الدخول</button>
                    </div>

                </div>
            </form>
{{--            <div class="social-auth-links text-center mt-2 mb-3">--}}
{{--                <a href="#" class="btn btn-block btn-primary">--}}
{{--                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook--}}
{{--                </a>--}}
{{--                <a href="#" class="btn btn-block btn-danger">--}}
{{--                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+--}}
{{--                </a>--}}
{{--            </div>--}}

{{--            <p class="mb-1">--}}
{{--                <a href="forgot-password.html">I forgot my password</a>--}}
{{--            </p>--}}
{{--            <p class="mb-0">--}}
{{--                <a href="register.html" class="text-center">Register a new membership</a>--}}
{{--            </p>--}}
        </div>

    </div>

</div>


<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/dist/js/adminlte.min.js?v=3.2.0') }}"></script>

<script>
    function login(username,password) {
        document.getElementById('email').value = username;
        document.getElementById('password').value = password;
    }
</script>
</body>
</html>
