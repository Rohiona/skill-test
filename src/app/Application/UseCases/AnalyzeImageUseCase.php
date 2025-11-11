<?php

namespace App\Application\UseCases;

use App\Application\Gateways\ImageClassificationPort;
use App\Application\Input\AnalyzeImageInput;
use App\Application\Repositories\AiAnalysisLog\AiAnalysisLogRepositoryInterface;
use Carbon\CarbonImmutable;

final class AnalyzeImageUseCase
{
    public function __construct(
        private readonly ImageClassificationPort $aiClient,
        private readonly AiAnalysisLogRepositoryInterface $logRepo,
    ) {}

    public function handle(AnalyzeImageInput $input): void
    {
        $now = CarbonImmutable::now();
        $result = $this->aiClient->classify($input->imagePath);

        $this->logRepo->create([
            'image_path' => $input->imagePath,
            'success' => $result->success,
            'message' => $result->message,
            'class' => $result->class,
            'confidence' => $result->confidence,
            'request_timestamp' => $now,
            'response_timestamp' => $now,
        ]);
    }
}
