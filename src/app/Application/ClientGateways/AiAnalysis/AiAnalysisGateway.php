<?php

namespace App\Application\ClientGateways\AiAnalysis;

interface AiAnalysisGateway
{
    public function analyze(string $imagePath): AiAnalysisGatewayResult;
}
