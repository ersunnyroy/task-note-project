<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// controllers
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\NoteController;


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


Route::post('register', [UserController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware('jwt.auth')->group(function () {
    // Create Tasks with notes
    Route::post('tasks', [TaskController::class, 'store']);
    // Retrieve all tasks with notes
    Route::get('tasks', [TaskController::class, 'index']);
    // Notes
    Route::post('notes', [NoteController::class, 'store']);
});