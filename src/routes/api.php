<?php

use App\Http\Controllers\Api\MockAiApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Mock AI API endpoint
Route::post('/mock/ai/analyze', [MockAiApiController::class, 'analyze']);
