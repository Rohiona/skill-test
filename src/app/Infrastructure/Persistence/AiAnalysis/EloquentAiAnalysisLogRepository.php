<?php

namespace App\Infrastructure\Persistence\AiAnalysis;

use App\Domain\AiAnalysisLog\Repositories\AiAnalysisLogRepositoryInterface;
use App\Models\AiAnalysisLog;

final class EloquentAiAnalysisLogRepository implements AiAnalysisLogRepositoryInterface
{
    public function create(array $data): void
    {
        AiAnalysisLog::query()->create($data);
    }
}
