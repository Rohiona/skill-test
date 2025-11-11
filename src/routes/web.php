<?php

use App\Http\Controllers\AiAnalysisController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AiAnalysisController::class, 'index'])->name('ai-analysis.index');
Route::post('/analyze', [AiAnalysisController::class, 'analyze'])->name('ai-analysis.analyze');
