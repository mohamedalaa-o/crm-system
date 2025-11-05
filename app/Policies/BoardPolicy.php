<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Board;
use App\Models\User;

class BoardPolicy
{
    /**
     * Determine if the user can view the board.
     */
    public function view(User $user, Board $board)
    {
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }

        if ($user->hasRole('Manager') && $board->members->contains($user)) {
            return Response::allow();
        }

        return Response::deny('You do not have access to this board.');
    }

    /**
     * Determine if the user can update the board.
     */
    public function update(User $user, Board $board)
    {
        // Managers can update boards they belong to, Admins can update all
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }

        if ($user->hasRole('Manager') && $board->members->contains($user)) {
            return Response::allow();
        }

        return Response::deny('You do not have permission to update this board.');
    }

    /**
     * Determine if the user can delete the board.
     */
    public function delete(User $user, Board $board)
    {
        // Only Admin can delete
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }

        return Response::deny('Only Admin can delete this board.');
    }
}
