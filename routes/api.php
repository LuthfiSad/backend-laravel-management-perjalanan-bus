<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\RuteController;
use App\Http\Controllers\SupirController;
use App\Http\Controllers\TerminalController;
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

Route::group(['middleware' => 'auth:sanctum'], function($router) {
    Route::apiResource('buses', BusController::class);
    Route::apiResource('supirs', SupirController::class);
    Route::apiResource('rutes', RuteController::class);
    Route::apiResource('jadwals', JadwalController::class);
    Route::apiResource('terminals', TerminalController::class);
    Route::get('buses-all', [BusController::class, 'indexAll'])->name("buses.all");
    Route::get('supirs-all', [SupirController::class, 'indexAll'])->name("supirs.all");
    Route::get('rutes-all', [RuteController::class, 'indexAll'])->name("rutes.all");
    Route::get('terminals-all', [TerminalController::class, 'indexAll'])->name("terminals.all");
  });
  
  Route::post('auth/login', [AuthController::class, 'login'])->name("login");
