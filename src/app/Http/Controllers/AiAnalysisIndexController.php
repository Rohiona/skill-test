<?php

namespace App\Http\Controllers;

use App\Application\Queries\AiAnalysis\Index\AiAnalysisLogsQueryPort;
use Illuminate\View\View;

final class AiAnalysisIndexController extends Controller
{
    public function __construct(private readonly AiAnalysisLogsQueryPort $aiAnalysisLogsQueryPort) {}

    public function __invoke(): View
    {
        return view('ai-analysis.index', [
            'logs' => $this->aiAnalysisLogsQueryPort->get(),
        ]);
    }
}
