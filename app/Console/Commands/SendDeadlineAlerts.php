<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;
use App\Notifications\DeadlineAlertNotification;

class SendDeadlineAlerts extends Command
{
    protected $signature = 'tasks:deadline-alerts';
    protected $description = 'Send notifications for tasks near their deadline';

    public function handle()
    {
        $now = Carbon::now();
        $threshold = $now->copy()->addHours(12); 

        $tasks = Task::where('deadline', '>=', $now)
                    ->where('deadline', '<=', $threshold)
                    ->where('status', '!=', 'done')
                    ->get();

        foreach ($tasks as $task) {
            if ($task->assigned_user_id) {
                $user = $task->assignedUser;
                $user->notify(new DeadlineAlertNotification($task));
            }
        }
    }
}
