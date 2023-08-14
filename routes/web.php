<?php

use App\Http\Controllers\FolderContentController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskTimeInteractionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])
        ->name('home');

    Route::post('/logout', [AuthController::class, 'logoutAttempt'])
        ->name('logoutAttempt');


    Route::prefix('api')->group(function () {
        Route::post('/folder-content/list', [FolderContentController::class, 'list']);
        Route::post('/folder-content/list-folders', [FolderContentController::class, 'listFolders']);


        Route::post('/tasks/edit-name', [TaskController::class, 'editName']);
        Route::post('/tasks/set-status', [TaskController::class, 'setStatus']);
        Route::post('/tasks/create-new', [TaskController::class, 'createNew']);
        Route::post('/tasks/move', [TaskController::class, 'changeParentFolder']);
        Route::post('/tasks/time-interaction/start', [TaskTimeInteractionController::class, 'startTimeInteraction']);
        Route::post('/tasks/time-interaction/end', [TaskTimeInteractionController::class, 'endTimeInteraction']);
        Route::post('/tasks/running', [TaskTimeInteractionController::class, 'runningTasks']);


        Route::post('/folders/edit-name', [FolderController::class, 'editName']);
        Route::post('/folders/set-status', [FolderController::class, 'setStatus']);
        Route::post('/folders/create-new', [FolderController::class, 'createNew']);
        Route::post('/folders/move', [FolderController::class, 'changeParentFolder']);
    });
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'loginAttempt'])
        ->name('loginAttempt');

    Route::get('/register', [AuthController::class, 'register'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'registerAttempt'])
        ->name('registerAttempt');
});


