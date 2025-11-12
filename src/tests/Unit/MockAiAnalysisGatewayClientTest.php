<?php

namespace Tests\Unit;

use App\Application\Support\RandomIntGeneratorInterface;
use App\Infrastructure\Api\MockAiAnalysisGatewayClient;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class MockAiAnalysisGatewayClientTest extends TestCase
{
    #[Test]
    public function test_乱数が閾値以下なら失敗レスポンスになる(): void
    {
        $client = new MockAiAnalysisGatewayClient(new class() implements RandomIntGeneratorInterface
        {
            public function shouldFail(): bool
            {
                return true;
            }

            public function classFrom(string $imagePath): int
            {
                return 1;
            }

            public function confidenceFrom(string $imagePath): float
            {
                return 0.85;
            }
        });

        $result = $client->analyze('/images/any.jpg');

        $this->assertFalse($result->success);
        $this->assertSame('Error:E50012', $result->message);
        $this->assertNull($result->class);
        $this->assertNull($result->confidence);
    }

    #[Test]
    public function test_乱数が閾値を超えると成功レスポンスになる(): void
    {
        $client = new MockAiAnalysisGatewayClient(new class() implements RandomIntGeneratorInterface
        {
            public function shouldFail(): bool
            {
                return false;
            }

            public function classFrom(string $imagePath): int
            {
                return 5;
            }

            public function confidenceFrom(string $imagePath): float
            {
                return 0.9;
            }
        });

        $result = $client->analyze('/images/success.jpg');

        $this->assertTrue($result->success);
        $this->assertSame(5, $result->class);
        $this->assertSame(0.9, $result->confidence);
    }
}
