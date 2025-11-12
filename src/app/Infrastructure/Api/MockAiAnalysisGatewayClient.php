<?php

namespace App\Infrastructure\Api;

use App\Application\ClientGateways\AiAnalysisGateway;
use App\Application\ClientGateways\AiAnalysisGatewayResult;
use App\Application\Support\RandomIntGeneratorInterface;
use Random\RandomException;

final class MockAiAnalysisGatewayClient implements AiAnalysisGateway
{
    public function __construct(private readonly RandomIntGeneratorInterface $random) {}

    /**
     * @throws RandomException
     */
    public function classify(string $imagePath): AiAnalysisGatewayResult
    {
        if ($this->random->shouldFail()) {
            return $this->failureResult();
        }

        return new AiAnalysisGatewayResult(
            success: true,
            class: $this->random->classFrom($imagePath),
            confidence: $this->random->confidenceFrom($imagePath),
            message: 'success'
        );
    }

    private function failureResult(): AiAnalysisGatewayResult
    {
        return new AiAnalysisGatewayResult(
            success: false,
            class: null,
            confidence: null,
            message: 'Error:E50012'
        );
    }
}
