<?php

use App\Http\Controllers\FolderContentController;
use App\Http\Controllers\TaskController;
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


Route::post('/tasks/edit-title', [TaskController::class, 'editTitle']);
