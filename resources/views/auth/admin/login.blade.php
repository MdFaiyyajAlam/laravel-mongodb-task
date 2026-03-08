@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="section-card border border-dark-subtle">
            <h4 class="mb-3">Admin Login</h4>

            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    {{ $errors->first() }}
                </div>
            @endif

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Admin Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberAdmin">
                        <label class="form-check-label" for="rememberAdmin">Remember me</label>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-dark">Admin Login</button>
                        <a href="{{ route('admin.register') }}" class="btn btn-outline-dark">Create admin account</a>
                        <a href="{{ route('user.login') }}" class="btn btn-outline-primary">User login</a>
                    </div>
                </form>
        </div>
    </div>
</div>
@endsection
