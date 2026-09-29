@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show jl-alert" role="alert">
        <i class="fas fa-circle-exclamation jl-alert__icon" aria-hidden="true"></i>
        <div class="jl-alert__body">
            <strong class="d-block mb-1">يرجى تصحيح الأخطاء التالية:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق"><span aria-hidden="true">&times;</span></button>
    </div>
@endif

@if(\Illuminate\Support\Facades\Session::has('fail'))
    <div class="alert alert-danger alert-dismissible fade show jl-alert" role="alert">
        <i class="fas fa-circle-exclamation jl-alert__icon" aria-hidden="true"></i>
        <div class="jl-alert__body">{{ session('fail') }}</div>
        <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق"><span aria-hidden="true">&times;</span></button>
    </div>
@endif
