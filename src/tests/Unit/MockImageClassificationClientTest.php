<?php

namespace Tests\Unit;

use App\Application\Support\RandomIntGeneratorInterface;
use App\Infrastructure\Api\MockImageClassificationClient;
use PHPUnit\Framework\Attributes\Test;
use Random\RandomException;
use Tests\TestCase;

final class MockImageClassificationClientTest extends TestCase
{
    /**
     * @throws RandomException
     */
    #[Test]
    public function test_乱数が閾値以下なら失敗レスポンスになる(): void
    {
        $client = new MockImageClassificationClient(new class() implements RandomIntGeneratorInterface
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
                return 0.5;
            }
        });

        $result = $client->classify('/images/any.jpg');

        $this->assertFalse($result->success);
        $this->assertSame('Error:E50012', $result->message);
        $this->assertNull($result->class);
        $this->assertNull($result->confidence);
    }

    /**
     * @throws RandomException
     */
    #[Test]
    public function test_乱数が閾値を超えると成功レスポンスになる(): void
    {
        $client = new MockImageClassificationClient(new class() implements RandomIntGeneratorInterface
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
                return 0.6789;
            }
        });

        $result = $client->classify('/images/success.jpg');

        $this->assertTrue($result->success);
        $this->assertSame(5, $result->class);
        $this->assertSame(0.6789, $result->confidence);
    }
}
