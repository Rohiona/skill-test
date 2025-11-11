<?php

namespace App\Services;

use App\Models\AiAnalysisLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AiAnalysisService
{
    private string $apiUrl;

    public function __construct()
    {
        // Mock APIのエンドポイント（本番環境では外部APIのURLを使用）
        $this->apiUrl = config('app.url') . '/api/mock/ai/analyze';
    }

    /**
     * 画像パスを受け取り、AI分析APIを呼び出してDBに保存
     *
     * @param string $imagePath
     * @return AiAnalysisLog
     */
    public function analyzeAndSave(string $imagePath): AiAnalysisLog
    {
        $requestTimestamp = Carbon::now();

        try {
            // APIリクエスト送信
            $response = Http::timeout(30)->post($this->apiUrl, [
                'image_path' => $imagePath
            ]);

            $responseTimestamp = Carbon::now();
            $responseData = $response->json();

            // レスポンスデータをパース
            $success = $responseData['success'] ?? false;
            $message = $responseData['message'] ?? '';
            $estimatedData = $responseData['estimated_data'] ?? [];

            // DBに保存
            $log = AiAnalysisLog::create([
                'image_path' => $imagePath,
                'success' => $success,
                'message' => $message,
                'class' => $estimatedData['class'] ?? null,
                'confidence' => $estimatedData['confidence'] ?? null,
                'request_timestamp' => $requestTimestamp,
                'response_timestamp' => $responseTimestamp,
            ]);

            return $log;

        } catch (\Exception $e) {
            // エラー時もDBに保存
            $responseTimestamp = Carbon::now();

            Log::error('AI Analysis API Error', [
                'image_path' => $imagePath,
                'error' => $e->getMessage()
            ]);

            $log = AiAnalysisLog::create([
                'image_path' => $imagePath,
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'class' => null,
                'confidence' => null,
                'request_timestamp' => $requestTimestamp,
                'response_timestamp' => $responseTimestamp,
            ]);

            return $log;
        }
    }
}
