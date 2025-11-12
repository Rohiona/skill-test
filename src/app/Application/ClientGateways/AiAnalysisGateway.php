<?php

namespace App\Application\ClientGateways;

interface AiAnalysisGateway
{
    public function analyze(string $imagePath): AiAnalysisGatewayResult;
}
