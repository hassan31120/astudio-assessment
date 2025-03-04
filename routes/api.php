<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('projects')->group(function () {
        Route::get('/filter', [ProjectController::class, 'filter']);
        Route::apiResource('/', ProjectController::class)->except(['create', 'edit']);
    });

    Route::apiResource('timesheets', TimesheetController::class)->except(['create', 'edit']);

    Route::apiResource('attributes', AttributeController::class)->except(['create', 'edit']);
    Route::post('/attribute-values', [AttributeValueController::class, 'store']);
    Route::put('/attribute-values/{id}', [AttributeValueController::class, 'update']);
    Route::delete('/attribute-values/{id}', [AttributeValueController::class, 'destroy']);
});
