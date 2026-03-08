@extends('layout')

@section('content')
<div class="section-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Admin: Task Management</h4>
        <a href="{{ route('admin.panel.dashboard') }}" class="btn btn-outline-secondary btn-sm">Back Dashboard</a>
    </div>

    @if(session('success'))<div class="alert alert-success py-2">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger py-2">{{ session('error') }}</div>@endif

    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-4">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="pending" @selected(request('status')==='pending')>Pending</option>
                <option value="completed" @selected(request('status')==='completed')>Completed</option>
            </select>
        </div>
        <div class="col-md-4">
            <select name="guard" class="form-select">
                <option value="">All Owners</option>
                <option value="web" @selected(request('guard')==='web')>Users</option>
                <option value="admin" @selected(request('guard')==='admin')>Admins</option>
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-dark">Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Title</th><th>Status</th><th>Owner</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ ucfirst($task->status) }}</td>
                        <td>{{ $task->owner_guard === 'admin' ? 'Admin' : 'User' }}</td>
                        <td>
                            <form action="{{ route('admin.panel.tasks.status', $task->_id) }}" method="POST" class="d-inline-flex gap-2">
                                @csrf @method('PATCH')
                                <select name="status" class="form-select form-select-sm">
                                    <option value="pending" @selected($task->status==='pending')>Pending</option>
                                    <option value="completed" @selected($task->status==='completed')>Completed</option>
                                </select>
                                <button class="btn btn-outline-primary btn-sm">Update</button>
                            </form>
                            <form action="{{ route('admin.panel.tasks.destroy', $task->_id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete task?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">No tasks found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $tasks->links() }}
</div>
@endsection
