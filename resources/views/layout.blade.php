<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Task Manager</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background: linear-gradient(135deg, #f5f7ff, #eef2ff);
        min-height: 100vh;
    }
    .app-shell {
        max-width: 980px;
        margin: 40px auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(0,0,0,.08);
        padding: 28px;
    }
    .section-card {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 20px;
        background: #fff;
    }
</style>

</head>

<body>

<div class="app-shell">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Laravel MongoDB Task Manager</h2>

    <div>
        @if(auth('admin')->check())
            <span class="badge text-bg-dark me-2">Admin: {{ auth('admin')->user()->name }}</span>
            <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                @csrf
                <button class="btn btn-outline-danger btn-sm">Admin Logout</button>
            </form>
        @elseif(auth('web')->check())
            <span class="badge text-bg-primary me-2">User: {{ auth('web')->user()->name }}</span>
            <form method="POST" action="{{ route('user.logout') }}" class="d-inline">
                @csrf
                <button class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
        @else
            <a href="{{ route('user.login') }}" class="btn btn-outline-primary btn-sm me-2">User Login</a>
            <a href="{{ route('admin.login') }}" class="btn btn-outline-dark btn-sm">Admin Login</a>
        @endif
    </div>
</div>

@yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
