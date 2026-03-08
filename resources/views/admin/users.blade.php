@extends('layout')

@section('content')
<div class="section-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Admin: User Management</h4>
        <a href="{{ route('admin.panel.dashboard') }}" class="btn btn-outline-secondary btn-sm">Back Dashboard</a>
    </div>

    @if(session('success'))<div class="alert alert-success py-2">{{ session('success') }}</div>@endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light"><tr><th>Name</th><th>Email</th><th>Created</th><th>Action</th></tr></thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ optional($user->created_at)->format('d M Y') }}</td>
                        <td>
                            <form action="{{ route('admin.panel.users.destroy', $user->_id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete user and their tasks?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
</div>
@endsection
