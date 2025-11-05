<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

class TaskController extends BaseController
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth:sanctum'); 
    }

    public function index()
    {
        $tasks = Task::with(['board', 'subtasks', 'attachments', 'comments', 'assignedUser'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'Tasks fetched successfully',
            'tasks' => $tasks
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'board_id' => 'required|exists:boards,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_user_id' => 'nullable|exists:users,id',
            'priority' => 'in:high,medium,low',
            'status' => 'in:todo,in-progress,done',
            'deadline' => 'nullable|date',
            'attachments.*' => 'file|max:20480',
        ]);

        $task = Task::create($validated);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store("tasks/{$task->id}/attachments", 'public');
                $task->attachments()->create(['path' => $path]);
            }
        }

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task->load('attachments')
        ], 201);
    }

    public function show(Task $task)
    {
        $task->load(['board', 'subtasks', 'attachments', 'comments', 'assignedUser']);

        return response()->json([
            'message' => 'Task fetched successfully',
            'task' => $task
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|nullable|string',
            'assigned_user_id' => 'nullable|exists:users,id',
            'priority' => 'sometimes|in:high,medium,low',
            'status' => 'sometimes|in:todo,in-progress,done',
            'deadline' => 'sometimes|nullable|date',
            'attachments.*' => 'file|max:20480',
        ]);

        $task->forceFill($request->only([
            'title', 'description', 'assigned_user_id', 'priority', 'status', 'deadline'
        ]))->save();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store("tasks/{$task->id}/attachments", 'public');
                $task->attachments()->create(['path' => $path]);
            }
        }

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task->load('attachments')
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully'
        ]);
    }

    public function getTasksByBoard($boardId)
    {
        $tasks = Task::where('board_id', $boardId)
            ->with(['subtasks', 'attachments', 'comments'])
            ->get();

        return response()->json([
            'message' => 'Tasks fetched successfully',
            'tasks' => $tasks
        ]);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:todo,in-progress,done'
        ]);

        $task->update(['status' => $request->status]);

        $pendingSubtasks = $task->subtasks()->where('status', '!=', 'done')->count();
        if ($pendingSubtasks === 0 && $task->status !== 'done') {
            $task->update(['status' => 'done']);
        } elseif ($pendingSubtasks > 0 && $task->status === 'done') {
            $task->update(['status' => 'in-progress']);
        }

        return response()->json([
            'message' => 'Status updated successfully',
            'task' => $task
        ]);
    }
}
