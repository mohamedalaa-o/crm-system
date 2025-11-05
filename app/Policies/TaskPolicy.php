<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function view(User $user, Task $task)
    {
        if ($user->hasRole('Admin')) return true; // Admin full access
        if ($user->hasRole('Manager') && $task->board->members->contains($user)) return true; // Manager sees tasks in assigned boards
        if ($user->hasRole('Member') && $task->assigned_user_id == $user->id) return true; // Member sees assigned tasks
        return false;
    }

    public function update(User $user, Task $task)
    {
        return $this->view($user, $task);
    }

    public function delete(User $user, Task $task)
    {
        return $this->view($user, $task);
    }
}
