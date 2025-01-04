<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DemandeCongeController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('employes', EmployeController::class)->middleware('auth:sanctum');
Route::apiResource('notifications', NotificationController::class)->middleware('auth:sanctum');
Route::apiResource('conges', DemandeCongeController::class)->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::put('/update-password', [AuthController::class, 'updatePassword'])->middleware('auth:sanctum');

