<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BenefitPlanController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ReportController;

// PUBLIC ROUTE 
Route::post('/login', [AuthController::class, 'login'])->name('login');

// PROTECTED ROUTE
Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('members', MemberController::class);
    Route::apiResource('benefit-plans', BenefitPlanController::class);

    Route::get('claims', [ClaimController::class, 'index']);
    Route::post('claims', [ClaimController::class, 'store']);
    Route::get('reports/claims', [ReportController::class, 'claims']);
});