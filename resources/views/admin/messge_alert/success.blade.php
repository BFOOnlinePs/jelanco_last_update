@if(\Illuminate\Support\Facades\Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show jl-alert" role="status">
        <i class="fas fa-circle-check jl-alert__icon" aria-hidden="true"></i>
        <div class="jl-alert__body">{{ session('success') }}</div>
        <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق"><span aria-hidden="true">&times;</span></button>
    </div>
@endif
