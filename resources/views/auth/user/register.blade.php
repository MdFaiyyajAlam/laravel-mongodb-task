@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="section-card">
            <h4 class="mb-3">User Register</h4>

            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    {{ $errors->first() }}
                </div>
            @endif

                <form method="POST" action="{{ route('user.register.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-success">Register</button>
                        <a href="{{ route('user.login') }}" class="btn btn-outline-secondary">Back to login</a>
                    </div>
                </form>
        </div>
    </div>
</div>
@endsection
