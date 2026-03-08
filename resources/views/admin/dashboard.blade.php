@extends('layout')

@section('content')
<div class="section-card mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0">Admin Dashboard</h4>
            <small class="text-muted">Analytics + management overview</small>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.panel.tasks') }}" class="btn btn-outline-dark btn-sm">Manage Tasks</a>
            <a href="{{ route('admin.panel.users') }}" class="btn btn-outline-dark btn-sm">Manage Users</a>
            <a href="{{ route('admin.panel.admins') }}" class="btn btn-outline-dark btn-sm">Manage Admins</a>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-3"><div class="section-card text-center"><h6>Total Users</h6><h3>{{ $totalUsers }}</h3></div></div>
    <div class="col-md-3"><div class="section-card text-center"><h6>Total Admins</h6><h3>{{ $totalAdmins }}</h3></div></div>
    <div class="col-md-3"><div class="section-card text-center"><h6>Total Tasks</h6><h3>{{ $totalTasks }}</h3></div></div>
    <div class="col-md-3"><div class="section-card text-center"><h6>Completed</h6><h3 class="text-success">{{ $completedTasks }}</h3></div></div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="section-card">
            <h6 class="mb-3">Tasks Created (Last 7 Days)</h6>
            <canvas id="taskTrendChart" height="120"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="section-card">
            <h6 class="mb-3">Task Ownership Split</h6>
            <canvas id="ownerChart" height="180"></canvas>
            <hr>
            <p class="mb-1">Pending: <strong class="text-warning">{{ $pendingTasks }}</strong></p>
            <p class="mb-0">Completed: <strong class="text-success">{{ $completedTasks }}</strong></p>
        </div>
    </div>
</div>

<div class="section-card mt-3">
    <h6 class="mb-3">Recent Tasks</h6>
    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Owner</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>
                            <span class="badge {{ $task->status === 'completed' ? 'text-bg-success' : 'text-bg-warning' }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </td>
                        <td>{{ $task->owner_guard === 'admin' ? 'Admin' : 'User' }}</td>
                        <td>{{ optional($task->created_at)->format('d M Y, h:i A') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted">No recent tasks found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('taskTrendChart'), {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Tasks',
                data: @json($dailyTaskCount),
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,0.15)',
                fill: true,
                tension: 0.3
            }]
        }
    });

    new Chart(document.getElementById('ownerChart'), {
        type: 'doughnut',
        data: {
            labels: ['Users', 'Admins'],
            datasets: [{
                data: [{{ $ownerBreakdown['users'] }}, {{ $ownerBreakdown['admins'] }}],
                backgroundColor: ['#0d6efd', '#212529']
            }]
        }
    });
</script>
@endsection
