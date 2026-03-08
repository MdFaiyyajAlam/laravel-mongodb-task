@extends('layout')

@section('content')
<div class="section-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Admin: Admin Management</h4>
        <a href="{{ route('admin.panel.dashboard') }}" class="btn btn-outline-secondary btn-sm">Back Dashboard</a>
    </div>

    @if(session('success'))<div class="alert alert-success py-2">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger py-2">{{ session('error') }}</div>@endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light"><tr><th>Name</th><th>Email</th><th>Created</th><th>Action</th></tr></thead>
            <tbody>
                @forelse($admins as $admin)
                    <tr>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ optional($admin->created_at)->format('d M Y') }}</td>
                        <td>
                            <form action="{{ route('admin.panel.admins.destroy', $admin->_id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete admin and their tasks?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">No admins found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $admins->links() }}
</div>
@endsection
