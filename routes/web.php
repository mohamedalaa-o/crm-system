<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // مهم عشان Auth facade ما يطلعش تحذير
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\HomeController;

// Route login مؤقت للتجربة
Route::get('/login', function() {
    return "Login Page (temporary)";
})->name('login');

// Route homepage
Route::get('/', function () {
    return view('welcome');
});

// Routes للـ Dashboard والـ CRUD تحت auth middleware
Route::middleware('auth')->group(function () {

    // Dashboard main view
    Route::get('/dashboard', [DashboardController::class, 'view'])->name('dashboard');

    // Boards CRUD
    Route::resource('boards', BoardController::class);

    // Tasks CRUD
    Route::resource('tasks', TaskController::class);
    Route::get('boards/{id}/tasks', [TaskController::class, 'getTasksByBoard']);
    Route::put('/tasks/{task}/status', [TaskController::class, 'updateStatus']);

    // Subtasks CRUD
    Route::post('tasks/{task}/subtasks', [SubtaskController::class, 'store']);
    Route::put('subtasks/{subtask}', [SubtaskController::class, 'update']);
    Route::delete('subtasks/{subtask}', [SubtaskController::class, 'destroy']);

    // Calendar
    Route::get('/calendar', [DashboardController::class, 'calendar']);
    Route::post('/calendar/update-deadline/{type}/{id}', [DashboardController::class, 'updateDeadline']);

    // Reports
    Route::get('/dashboard/report', [DashboardController::class, 'report']);
});

// Home route
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Laravel Auth routes (login, register, logout, etc.)
Auth::routes();
