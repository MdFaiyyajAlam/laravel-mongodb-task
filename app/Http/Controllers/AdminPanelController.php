<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPanelController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalAdmins = Admin::count();
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        $pendingTasks = Task::where('status', 'pending')->count();

        $ownerBreakdown = [
            'users' => Task::where('owner_guard', 'web')->count(),
            'admins' => Task::where('owner_guard', 'admin')->count(),
        ];

        $recentTasks = Task::latest()->limit(8)->get();

        $labels = [];
        $dailyTaskCount = [];
        $grouped = Task::where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->get(['created_at'])
            ->groupBy(fn ($task) => optional($task->created_at)->format('Y-m-d'));

        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $key = $day->format('Y-m-d');
            $labels[] = $day->format('d M');
            $dailyTaskCount[] = $grouped->has($key) ? $grouped[$key]->count() : 0;
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'ownerBreakdown',
            'recentTasks',
            'labels',
            'dailyTaskCount'
        ));
    }

    public function tasks(Request $request)
    {
        $query = Task::query()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('guard')) {
            $query->where('owner_guard', $request->string('guard')->toString());
        }

        $tasks = $query->paginate(12)->withQueryString();

        return view('admin.tasks', compact('tasks'));
    }

    public function updateTaskStatus(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,completed'],
        ]);

        Task::where('_id', $id)->update(['status' => $validated['status']]);

        return back()->with('success', 'Task status updated.');
    }

    public function destroyTask(string $id)
    {
        Task::where('_id', $id)->delete();

        return back()->with('success', 'Task deleted successfully.');
    }

    public function users()
    {
        $users = User::latest()->paginate(12);

        return view('admin.users', compact('users'));
    }

    public function destroyUser(string $id)
    {
        User::where('_id', $id)->delete();
        Task::where('owner_id', $id)->where('owner_guard', 'web')->delete();

        return back()->with('success', 'User and related tasks deleted.');
    }

    public function admins()
    {
        $admins = Admin::latest()->paginate(12);

        return view('admin.admins', compact('admins'));
    }

    public function destroyAdmin(string $id)
    {
        if ((string) Auth::guard('admin')->id() === $id) {
            return back()->with('error', 'You cannot delete your own admin account.');
        }

        Admin::where('_id', $id)->delete();
        Task::where('owner_id', $id)->where('owner_guard', 'admin')->delete();

        return back()->with('success', 'Admin and related tasks deleted.');
    }
}
