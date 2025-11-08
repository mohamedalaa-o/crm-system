// <?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\BoardController;

// use App\Http\Controllers\AuthController;

// Route::post('/register', [AuthController::class, 'registerAdmin']);
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Route::get('/ping', function () {
//     return response()->json(['message' => 'API is working ✅']);
// });
// Route::post('/registration', [AuthController::class, 'register']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('boards', BoardController::class); // API only
//     Route::apiResource('tasks', TaskController::class);   // API only
// });

// });
// Route::post('/users/assign-role', [AuthController::class, 'assignRole']);

// use App\Http\Controllers\TaskController;

// Route::apiResource('tasks', TaskController::class);
// Route::get('boards/{id}/tasks', [TaskController::class, 'getTasksByBoard']);
// Route::put('/tasks/{task}/status', [TaskController::class, 'updateStatus']);

// use App\Http\Controllers\CommentController;
// use App\Http\Controllers\SubtaskController;

//     // Comments
//     Route::post('tasks/{task}/comments', [CommentController::class, 'store']);
//     Route::get('tasks/{task}/comments', [CommentController::class, 'index']);

//     // Subtasks
//     Route::post('tasks/{task}/subtasks', [SubtaskController::class, 'store']);
//     Route::put('subtasks/{subtask}', [SubtaskController::class, 'update']);
//     Route::delete('subtasks/{subtask}', [SubtaskController::class, 'destroy']);

//     use App\Http\Controllers\DashboardController;
//     Route::get('/dashboard/report', [DashboardController::class, 'report']);

//     Route::get('/calendar', [DashboardController::class, 'calendar']);
//     Route::post('/calendar/update-deadline/{type}/{id}', [DashboardController::class, 'updateDeadline']);

