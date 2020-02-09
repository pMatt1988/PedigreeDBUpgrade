@if(session('fail'))
    <div class="alert alert-danger">{{ session('fail') }}</div>
@endif
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
