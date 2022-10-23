<?php

use App\Http\Controllers\FolderContentController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskTimeInteractionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/folder-content/list', [FolderContentController::class, 'list']);
Route::post('/folder-content/list-folders', [FolderContentController::class, 'listFolders']);


Route::post('/tasks/edit-name', [TaskController::class, 'editName']);
Route::post('/tasks/set-status', [TaskController::class, 'setStatus']);
Route::post('/tasks/create-new', [TaskController::class, 'createNew']);
Route::post('/tasks/move', [TaskController::class, 'changeParentFolder']);
Route::post('/tasks/time-interaction/start', [TaskTimeInteractionController::class, 'startTimeInteraction']);
Route::post('/tasks/time-interaction/end', [TaskTimeInteractionController::class, 'endTimeInteraction']);


Route::post('/folders/edit-name', [FolderController::class, 'editName']);
Route::post('/folders/set-status', [FolderController::class, 'setStatus']);
Route::post('/folders/create-new', [FolderController::class, 'createNew']);
Route::post('/folders/move', [FolderController::class, 'changeParentFolder']);

