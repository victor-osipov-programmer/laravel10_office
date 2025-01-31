<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [UserController::class, 'store']);
Route::post('/signin', [AuthController::class, 'signin']);
Route::post('/employees', [EmployeeController::class, 'store'])->middleware(['auth:sanctum']);
Route::get('/employees', [EmployeeController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->middleware(['auth:sanctum']);
Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->middleware(['auth:sanctum']);