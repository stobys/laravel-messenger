@if (session()->has('error_message'))
    <div class="alert alert-danger" role="alert">
        {{ session('error_message') }}
    </div>
@endif
