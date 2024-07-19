<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/test', function () {
        return response()->json(['data' => "Welcome message"], 200);
    });

    Route::get('/users', [UserController::class, 'users']);
    Route::get('/user/{id}', [UserController::class, 'user']);
    Route::patch('/user/{id}/update', [UserController::class, 'update']);
    Route::delete('/user/{id}/delete', [UserController::class, 'delete']);
    Route::post('/user/{id}/restore', [UserController::class, 'restore']);

    Route::post('/registerstudent', [StudentController::class, 'registerstudent']);
    Route::get('/students', [StudentController::class, 'students']);
    Route::get('/student/{id}', [StudentController::class, 'student']);
    Route::patch('/student/{id}/update', [StudentController::class, 'update']);
    Route::delete('/student/{id}/delete', [StudentController::class, 'delete']);
    Route::post('/student/{id}/restore', [StudentController::class, 'restore']);
});
