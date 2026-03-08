@extends('layout')

@section('content')
<div class="section-card mb-3">
    <h3 class="mb-2">Welcome 👋</h3>
    <p class="text-muted mb-0">
        MongoDB Task Manager me aap User ya Admin dono roles ke saath login/register kar sakte ho.
        Har role apne tasks ko securely manage karega.
    </p>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="section-card h-100">
            <h5>User Panel</h5>
            <p class="text-muted">Normal users ke liye login/register aur personal task management.</p>
            <a href="{{ route('user.login') }}" class="btn btn-primary me-2">User Login</a>
            <a href="{{ route('user.register') }}" class="btn btn-outline-primary">User Register</a>
        </div>
    </div>

    <div class="col-md-6">
        <div class="section-card h-100">
            <h5>Admin Panel</h5>
            <p class="text-muted">Admins ke liye separate authentication aur dedicated task space.</p>
            <a href="{{ route('admin.login') }}" class="btn btn-dark me-2">Admin Login</a>
            <a href="{{ route('admin.register') }}" class="btn btn-outline-dark">Admin Register</a>
        </div>
    </div>
</div>
@endsection
