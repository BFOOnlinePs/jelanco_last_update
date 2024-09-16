@if(\Illuminate\Support\Facades\Session::has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
