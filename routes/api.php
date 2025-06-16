<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CopieDemandesCongesController;
use App\Http\Controllers\DemandeCongeController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\NotificationController;
use App\Models\DemandeConge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('employes', EmployeController::class);
Route::apiResource('notifications', NotificationController::class)->middleware('auth:sanctum');
Route::apiResource('conges', DemandeCongeController::class)->middleware('auth:sanctum');

// Route pour accepter une demande de congé
Route::put('/conges/{id}/accept', [DemandeCongeController::class, 'acceptDemande'])->middleware('auth:sanctum');
Route::put('/conges/{id}/statut', [DemandeCongeController::class, 'updateStatut']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::put('/update-password', [AuthController::class, 'updatePassword'])->middleware('auth:sanctum');