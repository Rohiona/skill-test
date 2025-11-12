<?php

namespace App\Application\ClientGateways\AiAnalysis;

final class AiAnalysisGatewayResult
{
    public function __construct(
        public readonly bool $success,
        public readonly ?int $class,
        public readonly ?float $confidence,
        public readonly string $message
    ) {}
}
