<?php

namespace App\Application\UseCases\AiAnalysis;

final class AnalyzeImageUseCaseInput
{
    public function __construct(
        public readonly string $imagePath,
    ) {}
}
