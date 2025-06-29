<?php
// routes/api.php
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('articles', ArticleController::class);
});
