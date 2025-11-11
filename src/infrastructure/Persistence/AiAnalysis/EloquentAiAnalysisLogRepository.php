<?php

namespace App\Infrastructure\Persistence\AiAnalysis;

use App\Models\AiAnalysisLog;
use Domain\AiAnalysisLog\Repositories\AiAnalysisLogRepositoryInterface;

final class EloquentAiAnalysisLogRepository implements AiAnalysisLogRepositoryInterface
{
    public function create(array $data): void
    {
        AiAnalysisLog::query()->create($data);
    }
}
