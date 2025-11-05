<?php

namespace App\Policies;

use App\Models\Subtask;
use App\Models\User;

class SubtaskPolicy
{
    public function view(User $user, Subtask $subtask)
    {
        if ($user->hasRole('Admin')) return true;
        if ($user->hasRole('Manager') && $subtask->task->board->members->contains($user)) return true;
        if ($user->hasRole('Member') && $subtask->assigned_user_id == $user->id) return true;
        return false;
    }

    public function update(User $user, Subtask $subtask)
    {
        return $this->view($user, $subtask);
    }

    public function delete(User $user, Subtask $subtask)
    {
        return $this->view($user, $subtask);
    }
}
