@extends('layout')

@section('content')
<div class="section-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Your Tasks</h4>
            <small class="text-muted">Total: {{ $tasks->count() }}</small>
        </div>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ Add Task</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2">{{ session('success') }}</div>
    @endif

    @if($tasks->isEmpty())
        <div class="alert alert-info mb-0">No tasks yet. Create your first task.</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td class="fw-semibold">{{ $task->title }}</td>
                            <td>{{ $task->description ?: '-' }}</td>
                            <td>
                                <span class="badge {{ $task->status === 'completed' ? 'text-bg-success' : 'text-bg-warning' }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('tasks.edit',$task->_id) }}" class="btn btn-outline-warning btn-sm">Edit</a>

                                <form action="{{ route('tasks.destroy',$task->_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this task?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
