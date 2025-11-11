<?php

namespace App\Http\Controllers;

use App\Application\Input\AnalyzeImageInput;
use App\Application\UseCases\AnalyzeImageUseCase;
use App\Http\Requests\AnalyzeImageRequest;
use Illuminate\Http\JsonResponse;

final class AnalyzeController extends Controller
{
    public function __construct(
        private readonly AnalyzeImageUseCase $analyzeImageUseCase,
    ) {}

    public function __invoke(AnalyzeImageRequest $request): JsonResponse
    {
        $this->analyzeImageUseCase->handle(new AnalyzeImageInput($request->validated('image_path')));

        return response()->json(['status' => 'created'], 201);
    }
}
