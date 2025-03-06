<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PosterController;
use App\Http\Controllers\Api\RegionsController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'getUser']);



    // E'lonlar uchun CRUD
    Route::post('/poster', [PosterController::class, 'store']) ->middleware('is_admin');
    Route::get('/poster/{id}', [PosterController::class, 'show']);
    Route::put('/poster/{id}', [PosterController::class, 'update'])->middleware('is_admin');
    Route::delete('/poster/{id}', [PosterController::class, 'destroy'])->middleware('is_admin');

    // Categoriya Region va Hashtaglarni qaytaradigan route. HomePage, PosterUpdate va PosterCreate pagelar uchun
    // bu qiymat redisga keshlab qaytariladi
    Route::get('/regandcat', [RegionsController::class, 'index']);

    // hamma posterlarni sortlab, filterlab,  paginatsiya bilan chiqarish uchun route
    Route::post('/posterall', [PosterController::class, 'index']);

    // Like bosish va olib tashlash uchun route
    Route::get('/posterlike/{id}', [PosterController::class, 'toggleLike']);
});
