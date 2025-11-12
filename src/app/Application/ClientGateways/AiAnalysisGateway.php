<?php

namespace App\Application\ClientGateways;

interface AiAnalysisGateway
{
    public function classify(string $imagePath): AiAnalysisGatewayResult;
}
