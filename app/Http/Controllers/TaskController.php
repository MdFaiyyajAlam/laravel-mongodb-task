<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    private function currentAuthContext(): array
    {
        if (Auth::guard('admin')->check()) {
            return ['guard' => 'admin', 'id' => (string) Auth::guard('admin')->id()];
        }

        return ['guard' => 'web', 'id' => (string) Auth::guard('web')->id()];
    }

    public function index()
    {
        $auth = $this->currentAuthContext();

        $tasks = Task::where('owner_id', $auth['id'])
            ->where('owner_guard', $auth['guard'])
            ->latest()
            ->get();

        return view('tasks.index', compact('tasks', 'auth'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,completed'],
        ]);

        $auth = $this->currentAuthContext();

        Task::create([
            ...$validated,
            'owner_id' => $auth['id'],
            'owner_guard' => $auth['guard'],
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task Created');
    }

    public function edit($id)
    {
        $auth = $this->currentAuthContext();

        $task = Task::where('_id', $id)
            ->where('owner_id', $auth['id'])
            ->where('owner_guard', $auth['guard'])
            ->firstOrFail();

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,completed'],
        ]);

        $auth = $this->currentAuthContext();

        $task = Task::where('_id', $id)
            ->where('owner_id', $auth['id'])
            ->where('owner_guard', $auth['guard'])
            ->firstOrFail();

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task Updated');
    }

    public function destroy($id)
    {
        $auth = $this->currentAuthContext();

        Task::where('_id', $id)
            ->where('owner_id', $auth['id'])
            ->where('owner_guard', $auth['guard'])
            ->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task Deleted');
    }
}
