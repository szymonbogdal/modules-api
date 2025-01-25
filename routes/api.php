<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => ['Aviailable routes:','POST /modules','GET /modules/{id}/download']
    ]);
});
Route::post('/modules', [App\Http\Controllers\ModuleController::class, 'createModule']);
Route::get('/modules/{id}/download', [App\Http\Controllers\ModuleController::class, 'downloadModule']);
