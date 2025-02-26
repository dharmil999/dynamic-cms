<?php

use App\Http\Controllers\Api\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/pages', [PageController::class, 'index']);
Route::post('/pages/create', [PageController::class, 'store']);
Route::get('/pages/{path?}', [PageController::class, 'show'])->where('path', '.*'); // This allows capturing nested paths dynamically
Route::put('/pages/{page}', [PageController::class, 'update']);
Route::delete('/pages/{page}', [PageController::class, 'destroy']);

