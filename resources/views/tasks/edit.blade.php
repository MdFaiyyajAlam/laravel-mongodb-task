@extends('layout')

@section('content')
<div class="section-card">
    <h4 class="mb-3">Edit Task</h4>

    @if ($errors->any())
        <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('tasks.update',$task->_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="pending" @selected(old('status', $task->status) === 'pending')>Pending</option>
                <option value="completed" @selected(old('status', $task->status) === 'completed')>Completed</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-success">Update Task</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>

@endsection
