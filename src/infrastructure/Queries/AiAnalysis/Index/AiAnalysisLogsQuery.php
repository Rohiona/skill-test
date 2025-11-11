<?php

namespace App\Infrastructure\Queries\AiAnalysis\Index;

use App\Application\QueryPorts\AiAnalysis\Index\AiAnalysisLogsQueryPort;
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
