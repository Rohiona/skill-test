<?php

namespace App\Http\Controllers;

use App\Application\Input\AnalyzeImageInput;
use App\Application\UseCases\AnalyzeImageUseCase;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

final class AiAnalysisStoreController extends Controller
{
    public function __construct(private readonly AnalyzeImageUseCase $analyzeImageUseCase) {}

    public function __invoke(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'image_path' => ['required', 'string', 'max:255', 'regex:/^\/[A-Za-z0-9_\-\/]+\.(jpe?g|png)$/i'],
        ], [
            'image_path.regex' => '画像パスは /xxx/yyy.jpg の形式で入力してください。',
        ]);

        try {
            $result = $this->analyzeImageUseCase->handle(new AnalyzeImageInput($validated['image_path']));

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
