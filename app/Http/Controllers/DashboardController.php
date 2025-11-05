<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Board;
use App\Models\Subtask;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function report()
    {
        $tasks = Task::with(['board', 'assignedUser'])->get();

        $users = User::all();

        $boards = Board::all();

        return response()->json([
            'boards' => $boards,
            'users' => $users,
            'tasks' => $tasks,
        ]);
    }

    // 1️⃣ Calendar View API
    public function calendar()
    {
        $tasks = Task::with(['subtasks', 'assignedUser', 'board'])->get();

        $events = $tasks->flatMap(function($task){
            // المهمة نفسها كحدث
            $taskEvent = [
                'id' => 'task-'.$task->id,
                'title' => $task->title,
                'start' => $task->deadline,
                'type' => 'task',
                'status' => $task->status,
                'user_id' => $task->assigned_to,
                'board_id' => $task->board_id,
            ];

            $subtaskEvents = $task->subtasks->map(function($subtask) use ($task){
                return [
                    'id' => 'subtask-'.$subtask->id,
                    'title' => $subtask->title,
                    'start' => $subtask->deadline,
                    'type' => 'subtask',
                    'status' => $subtask->status,
                    'task_id' => $task->id,
                    'user_id' => $subtask->assigned_to,
                    'board_id' => $task->board_id,
                ];
            });

            return $subtaskEvents->prepend($taskEvent);
        });

        return response()->json($events);
    }

    public function updateDeadline(Request $request, $type, $id)
    {
        $request->validate([
            'deadline' => 'required|date',
        ]);

        if ($type === 'task') {
            $item = Task::findOrFail($id);
        } else {
            $item = Subtask::findOrFail($id);
        }

        $item->deadline = $request->deadline;
        $item->save();

        return response()->json([
            'message' => ucfirst($type).' deadline updated successfully',
            'item' => $item
        ]);
    }
}
