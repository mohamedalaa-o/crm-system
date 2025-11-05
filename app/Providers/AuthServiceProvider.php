<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Board;
use App\Policies\BoardPolicy;
use App\Policies\SubtaskPolicy;
use App\Policies\TaskPolicy;
use App\Models\Subtask;
use App\Models\Task;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        Board::class => BoardPolicy::class,
        Task::class => TaskPolicy::class,
        Subtask::class => SubtaskPolicy::class,
    ];



    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
