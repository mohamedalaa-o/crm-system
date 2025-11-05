<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string',
            'assigned_user_id' => 'nullable|exists:users,id',
            'deadline' => 'nullable|date'
        ]);

        $subtask = $task->subtasks()->create($request->all());

        $this->updateParentTaskStatus($task);

        return response()->json([
            'message' => 'Subtask created successfully',
            'subtask' => $subtask
        ]);
    }

    public function update(Request $request, Subtask $subtask)
    {
        $request->validate([
            'title' => 'sometimes|string',
            'status' => 'sometimes|in:pending,done',
            'assigned_user_id' => 'nullable|exists:users,id',
            'deadline' => 'nullable|date'
        ]);

        $subtask->update($request->all());

        $this->updateParentTaskStatus($subtask->task);

        return response()->json([
            'message' => 'Subtask updated successfully',
            'subtask' => $subtask
        ]);
    }

    public function destroy(Subtask $subtask)
    {
        $task = $subtask->task;
        $subtask->delete();

        $this->updateParentTaskStatus($task);

        return response()->json(['message' => 'Subtask deleted successfully']);
    }

    /**
     */
    private function updateParentTaskStatus(Task $task)
    {
        $pendingSubtasks = $task->subtasks()->where('status', '!=', 'done')->count();

        if ($pendingSubtasks === 0) {
            if ($task->status !== 'done') {
                $task->update(['status' => 'done']);
            }
        } else {
            if ($task->status === 'done') {
                $task->update(['status' => 'in-progress']);
            }
        }
    }
}
