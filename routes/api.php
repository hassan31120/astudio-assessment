<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;

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

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

    Route::apiResource('timesheets', TimesheetController::class)->except(['create', 'edit']);

    Route::apiResource('attributes', AttributeController::class)->except(['create', 'edit']);
    Route::post('/attribute-values', [AttributeValueController::class, 'store']);
    Route::put('/attribute-values/{attributeValue}', [AttributeValueController::class, 'update']);
    Route::delete('/attribute-values/{attributeValue}', [AttributeValueController::class, 'destroy']);

    Route::get('/projects/filter', [ProjectController::class, 'filter']);
});
