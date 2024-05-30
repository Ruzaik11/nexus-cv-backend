<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\XssSanitization;
use App\Http\Controllers\Api\CVController;
use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\ValidateHostHeader;
use App\Http\Controllers\Api\AuthController;

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

Route::middleware([ForceJsonResponse::class, XssSanitization::class, ValidateHostHeader::class])->group(function () {
    Route::post('/auth/register', [AuthController::class, 'createUser']);
    Route::post('/auth/login', [AuthController::class, 'loginUser']);
    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/cv/save', [CVController::class, 'saveCV']);
        Route::get('/cv/get/{id}', [CVController::class, 'getCv']);
    });
});
