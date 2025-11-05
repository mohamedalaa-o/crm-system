<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NewCommentNotification;
use App\Notifications\MentionNotification;

class CommentController extends Controller
{
    public function index(Task $task)
    {
        return response()->json($task->comments()->with('user')->get());
    }

    public function store(Request $request, Task $task)
    {
        $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'attachments.*' => 'file'
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachments[] = $file->store("comments/{$task->id}", 'public');
            }
        }

        $comment = $task->comments()->create([
            'user_id' => $request->user_id,
            'content' => $request->content,
            'attachments' => $attachments
        ]);

        if ($task->assigned_user_id) {
            $assignedUser = User::find($task->assigned_user_id);
            if ($assignedUser && $assignedUser->id !== $request->user_id) {
                $assignedUser->notify(new NewCommentNotification($comment));
            }
        }

        preg_match_all('/@([\w]+)/', $request->content, $matches);
        if (!empty($matches[1])) {
            $mentionedUsernames = $matches[1];
            $mentionedUsers = User::whereIn('name', $mentionedUsernames)->get();
            foreach ($mentionedUsers as $user) {
                $user->notify(new MentionNotification($comment));
            }
        }


        return response()->json([
            'message' => 'Comment added successfully and notifications sent',
            'comment' => $comment
        ]);
    }
}
