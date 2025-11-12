<?php

namespace Tests\Feature;

use App\Application\ClientGateways\AiAnalysisGateway;
use App\Application\ClientGateways\AiAnalysisGatewayResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use ReflectionException;
use Tests\TestCase;

final class AiAnalysisStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws ReflectionException
     */
    #[DataProvider('validPathProvider')]
    public function test_分析成功時にログ保存と成功メッセージを表示する(string $imagePath): void
    {
        $result = new AiAnalysisGatewayResult(true, 3, 0.8, 'success');
        $this->bindGateway($result);

        $response = $this->post(route('ai-analysis.analyze'), [
            'image_path' => $imagePath,
        ]);

        $response->assertRedirect(route('ai-analysis.index'));
        $response->assertSessionHas('success', '画像分析が完了しました。');

        $this->assertDatabaseHas('ai_analysis_log', [
            'image_path' => $imagePath,
            'success' => true,
            'message' => 'success',
            'class' => 3,
            'confidence' => '0.8000',
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function test_分析失敗時にエラーメッセージと失敗ログを記録する(): void
    {
        $result = new AiAnalysisGatewayResult(false, null, null, 'Error:E50012');
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

    #[DataProvider('invalidPathProvider')]
    public function test_不正なパス形式はバリデーションエラーになる(string $imagePath): void
    {
        $response = $this->post(route('ai-analysis.analyze'), [
            'image_path' => $imagePath,
        ]);

        $response->assertSessionHasErrors('image_path');
        $this->assertDatabaseCount('ai_analysis_log', 0);
    }

    /**
     * @return array<string, array{string}>
     */
    public static function validPathProvider(): array
    {
        return [
            'jpeg' => ['/images/sample.jpg'],
            'png' => ['/foo/bar/sample.PNG'],
            'gif' => ['/foo_01/bar-02/file.gif'],
            'bmp' => ['/drive_x/path/file.bmp'],
            'webp' => ['/foo/bar/sample.webp'],
        ];
    }

    /**
     * @return array<string, array{string}>
     */
    public static function invalidPathProvider(): array
    {
        return [
            'missing_slash' => ['image.png'],
            'missing_ext' => ['/foo/bar'],
            'double_dot' => ['/foo../bar.jpg'],
            'unsupported_ext' => ['/foo/bar.txt'],
        ];
    }

    /**
     * @throws ReflectionException
     */
    private function bindGateway(AiAnalysisGatewayResult $result): void
    {
        $this->app->bind(AiAnalysisGateway::class, function () use ($result) {
            return new class($result) implements AiAnalysisGateway
            {
                public function __construct(private readonly AiAnalysisGatewayResult $result) {}

                public function analyze(string $imagePath): AiAnalysisGatewayResult
                {
                    return $this->result;
                }
            };
        });
    }
}
