<?php

use App\Http\Controllers\Api\AssignmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\EquipmentController;
use Illuminate\Support\Facades\Route;

// Public auth route used by client app to obtain API token.
Route::post('/login', [AuthController::class, 'login']);

// All business routes are token-protected for client-server security.
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Equipment CRUD endpoints.
    Route::apiResource('equipments', EquipmentController::class);

    // Assignment endpoints: create assignment, list assignments, return equipment.
    Route::get('/assignments', [AssignmentController::class, 'index']);
    Route::post('/assignments', [AssignmentController::class, 'store']);
    Route::patch('/assignments/{assignment}/return', [AssignmentController::class, 'markReturned']);

    // Dashboard stats endpoint for client home screen cards.
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
});
