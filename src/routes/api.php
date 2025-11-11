<?php

use App\Http\Controllers\AnalyzeController;
use Illuminate\Support\Facades\Route;

Route::post('/analyze-and-log', AnalyzeController::class);
