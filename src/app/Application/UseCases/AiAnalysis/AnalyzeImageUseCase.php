<?php

namespace App\Application\UseCases\AiAnalysis;

use App\Application\ClientGateways\AiAnalysis\AiAnalysisGateway;
use App\Application\ClientGateways\AiAnalysis\AiAnalysisGatewayResult;
use App\Domain\AiAnalysisLog\Repositories\AiAnalysisLogRepositoryInterface;
use Carbon\CarbonImmutable;

final class AnalyzeImageUseCase
{
    public function __construct(
        private readonly AiAnalysisGateway $aiClient,
        private readonly AiAnalysisLogRepositoryInterface $logRepo,
    ) {}

    public function handle(AnalyzeImageUseCaseInput $input): AiAnalysisGatewayResult
    {
        $now = CarbonImmutable::now();
        $result = $this->aiClient->analyze($input->imagePath);

        $this->logRepo->create([
            'image_path' => $input->imagePath,
            'success' => $result->success,
            'message' => $result->message,
            'class' => $result->class,
            'confidence' => $result->confidence,
            'request_timestamp' => $now,
            'response_timestamp' => $now,
        ]);

        return $result;
    }
}
