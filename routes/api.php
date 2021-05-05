<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('guest:api')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'store']);

    Route::post('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/articles', [ArticleController::class, 'index']);
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::get('/articles/{article}', [ArticleController::class, 'show']);
    Route::put('/articles/{article}', [ArticleController::class, 'update']);
    Route::patch('/articles/{article}', [ArticleController::class, 'update']);
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);
});
