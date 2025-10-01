<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// يرجع اليوزر الحالي بالـ token
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// صفحة ترحيب
Route::get('welcome', [WelcomeController::class, 'welcome']);

// Authentication
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // User routes
    Route::get('user/{id}', [UserController::class, 'checkUser']);
    Route::get('user/{id}/profile', [UserController::class, 'getprofile']);
    Route::get('user/{id}/tasks', [UserController::class, 'getUserTasks']);

    // Profile routes
    Route::post('profiles', [ProfileController::class, 'store']);
    Route::get('profiles/{id}', [ProfileController::class, 'show']);

    // Task routes
    Route::get('task/{id}/user', [TaskController::class, 'getTaskUser']);
    Route::post('tasks/{taskId}/categories', [TaskController::class, 'addCategoryToTask']);

        Route::get('task/all', [TaskController::class, 'getAllTasks'])->middleware('CheckUser');


    // Task CRUD باستخدام apiResource
    Route::apiResource('tasks', TaskController::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
});
// Category routes