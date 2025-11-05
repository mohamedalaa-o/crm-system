<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Comment;

class NewCommentNotification extends Notification
{
    use Queueable;

    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database']; // ممكن تضيف 'mail' لو تحب البريد
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "New comment on task: {$this->comment->task->title}",
            'comment_id' => $this->comment->id,
            'task_id' => $this->comment->task->id,
            'from_user_id' => $this->comment->user_id,
        ];
    }
}
