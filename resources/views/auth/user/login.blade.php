@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="section-card">
            <h4 class="mb-3">User Login</h4>

            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    {{ $errors->first() }}
                </div>
            @endif

                <form method="POST" action="{{ route('user.login.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberUser">
                        <label class="form-check-label" for="rememberUser">Remember me</label>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-primary">Login</button>
                        <a href="{{ route('user.register') }}" class="btn btn-outline-primary">Create user account</a>
                        <a href="{{ route('admin.login') }}" class="btn btn-outline-dark">Admin login</a>
                    </div>
                </form>
        </div>
    </div>
</div>
@endsection
