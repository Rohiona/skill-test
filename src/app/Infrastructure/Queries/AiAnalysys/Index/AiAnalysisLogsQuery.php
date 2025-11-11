<?php

namespace App\Infrastructure\Queries\AiAnalysys\Index;

use App\Application\Queries\AiAnalysis\Index\AiAnalysisLogsQueryPort;
use App\Models\AiAnalysisLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AiAnalysisLogsQuery implements AiAnalysisLogsQueryPort
{
    /**
     * {@inheritdoc}
     */
    public function get(): LengthAwarePaginator
    {
        return AiAnalysisLog::query()
            ->orderBy('id', 'desc')
            ->paginate(20);
    }
}
