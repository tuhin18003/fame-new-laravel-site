<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\DashboardController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//public api
Route::prefix('v1')->group(function () {
    Route::post( "signup", [ AuthController::class, 'signup' ] );
    Route::post( "login", [ AuthController::class, 'login' ] );
});

//private api
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard']);
    Route::get('logout', [AuthController::class, 'logout']);
});
