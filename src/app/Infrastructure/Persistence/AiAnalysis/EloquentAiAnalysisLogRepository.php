<?php

namespace App\Infrastructure\Persistence\AiAnalysis;

use App\Application\Repositories\AiAnalysisLog\AiAnalysisLogRepositoryInterface;
use App\Models\AiAnalysisLog;

final class EloquentAiAnalysisLogRepository implements AiAnalysisLogRepositoryInterface
{
    public function create(array $data): void
    {
        AiAnalysisLog::query()->create($data);
    }
}
