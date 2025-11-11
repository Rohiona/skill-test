<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MockAiApiController extends Controller
{
    public function analyze(Request $request): JsonResponse
    {
        $imagePath = $request->input('image_path');

        // image_pathが無い場合はエラー
        if (empty($imagePath)) {
            return response()->json([
                'success' => false,
                'message' => 'Error:E50012',
                'estimated_data' => []
            ], 400);
        }

        // 80%の確率で成功レスポンスを返す（ランダムにSuccess/Failureを切り替え）
        $isSuccess = rand(1, 100) <= 80;

        if ($isSuccess) {
            // Success レスポンス
            return response()->json([
                'success' => true,
                'message' => 'success',
                'estimated_data' => [
                    'class' => rand(1, 10), // ランダムなクラス（1-10）
                    'confidence' => round(rand(5000, 9999) / 10000, 4) // 0.5000 ~ 0.9999
                ]
            ]);
        } else {
            // Failure レスポンス
            $errorCodes = ['E50012', 'E50013', 'E50014', 'E50015'];
            return response()->json([
                'success' => false,
                'message' => 'Error:' . $errorCodes[array_rand($errorCodes)],
                'estimated_data' => []
            ], 500);
        }
    }
}
