<?php

namespace App\Application\QueryPorts\AiAnalysis\Index;

use App\Models\AiAnalysisLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AiAnalysisLogsQueryPort
{
    /**
     * @return LengthAwarePaginator<AiAnalysisLog>
     */
    public function get(): LengthAwarePaginator;
}
