<?php

namespace Tests\Feature;

use App\Application\ClientGateways\ImageClassificationGateway;
use App\Application\ClientGateways\ImageClassifyResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class AiAnalysisStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_分析成功時にログ保存と成功メッセージを表示する(): void
    {
        $result = new ImageClassifyResult(true, 3, 0.8, 'success');
        $this->bindGateway($result);

        $response = $this->post(route('ai-analysis.analyze'), [
            'image_path' => '/images/sample.jpg',
        ]);

        $response->assertRedirect(route('ai-analysis.index'));
        $response->assertSessionHas('success', '画像分析が完了しました。');

        $this->assertDatabaseHas('ai_analysis_log', [
            'image_path' => '/images/sample.jpg',
            'success' => true,
            'message' => 'success',
            'class' => 3,
            'confidence' => '0.8000',
        ]);
    }

    public function test_分析失敗時にエラーメッセージと失敗ログを記録する(): void
    {
        $result = new ImageClassifyResult(false, null, null, 'Error:E50012');
        $this->bindGateway($result);

        $response = $this->post(route('ai-analysis.analyze'), [
            'image_path' => '/images/failure.jpg',
        ]);

        $response->assertRedirect(route('ai-analysis.index'));
        $response->assertSessionHas('error', 'AI分析が失敗しました: Error:E50012');

        $this->assertDatabaseHas('ai_analysis_log', [
            'image_path' => '/images/failure.jpg',
            'success' => false,
            'message' => 'Error:E50012',
        ]);
    }

    public function test_不正なパス形式はバリデーションエラーになる(): void
    {
        $response = $this->post(route('ai-analysis.analyze'), [
            'image_path' => 'not-a-path',
        ]);

        $response->assertSessionHasErrors('image_path');
        $this->assertDatabaseCount('ai_analysis_log', 0);
    }

    private function bindGateway(ImageClassifyResult $result): void
    {
        $this->app->bind(ImageClassificationGateway::class, function () use ($result) {
            return new class($result) implements ImageClassificationGateway
            {
                public function __construct(private ImageClassifyResult $result) {}

                public function classify(string $imagePath): ImageClassifyResult
                {
                    return $this->result;
                }
            };
        });
    }
}
