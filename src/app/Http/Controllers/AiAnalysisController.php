<?php

namespace App\Http\Controllers;

use App\Models\AiAnalysisLog;
use App\Services\AiAnalysisService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AiAnalysisController extends Controller
{
    private AiAnalysisService $aiAnalysisService;

    public function __construct(AiAnalysisService $aiAnalysisService)
    {
        $this->aiAnalysisService = $aiAnalysisService;
    }

    /**
     * フォーム表示＆ログ一覧
     */
    public function index(): View
    {
        $logs = AiAnalysisLog::orderBy('id', 'desc')->paginate(20);

        return view('ai-analysis.index', compact('logs'));
    }

    /**
     * API実行処理
     */
    public function analyze(Request $request): RedirectResponse
    {
        $request->validate([
            'image_path' => 'required|string|max:255',
        ]);

        $imagePath = $request->input('image_path');

        try {
            $log = $this->aiAnalysisService->analyzeAndSave($imagePath);

            if ($log->success) {
                return redirect()->route('ai-analysis.index')
                    ->with('success', 'AI分析が正常に完了しました。');
            } else {
                return redirect()->route('ai-analysis.index')
                    ->with('error', 'AI分析が失敗しました: ' . $log->message);
            }
        } catch (Exception $e) {
            return redirect()->route('ai-analysis.index')
                ->with('error', 'エラーが発生しました: ' . $e->getMessage());
        }
    }
}
