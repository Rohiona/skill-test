<?php

namespace App\Http\Controllers;

use App\Application\UseCases\AiAnalysis\AnalyzeImageUseCase;
use App\Http\Requests\AiAnalysisStoreRequest;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

final class AiAnalysisStoreController extends Controller
{
    public function __construct(private readonly AnalyzeImageUseCase $analyzeImageUseCase) {}

    public function __invoke(AiAnalysisStoreRequest $request): RedirectResponse
    {
        try {
            $result = $this->analyzeImageUseCase->handle(input: $request->getAnalyzeImageInput());

            if ($result->success) {
                return redirect()
                    ->route('ai-analysis.index')
                    ->with('success', '画像分析が完了しました。');
            }

            return redirect()
                ->route('ai-analysis.index')
                ->with('error', 'AI分析が失敗しました: ' . $result->message);
        } catch (Exception $e) {
            Log::error($e);

            return redirect()
                ->route('ai-analysis.index')
                ->with('error', '分析中にエラーが発生しました: ' . $e->getMessage());
        }
    }
}
