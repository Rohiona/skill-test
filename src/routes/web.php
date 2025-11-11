<?php

use App\Http\Controllers\AiAnalysisIndexController;
use App\Http\Controllers\AiAnalysisStoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', AiAnalysisIndexController::class)->name('ai-analysis.index');
Route::post('/analyze', AiAnalysisStoreController::class)->name('ai-analysis.analyze');
