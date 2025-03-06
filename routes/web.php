<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/download/{filename}', function ($filename) {
    $path = storage_path("app/public/zip/{$filename}");

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->download($path);
})->name('download.file');
