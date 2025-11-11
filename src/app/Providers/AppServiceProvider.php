<?php

namespace App\Providers;

use App\Application\Gateways\ImageClassificationPort;
use App\Application\Queries\AiAnalysis\Index\AiAnalysisLogsQueryPort;
use App\Application\Repositories\AiAnalysisLog\AiAnalysisLogRepositoryInterface;
use App\Infrastructure\Api\MockImageClassificationClient;
use App\Infrastructure\Persistence\AiAnalysis\EloquentAiAnalysisLogRepository;
use App\Infrastructure\Queries\AiAnalysys\Index\AiAnalysisLogsQuery;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ImageClassificationPort::class,
            MockImageClassificationClient::class
        );

        $this->app->bind(
            AiAnalysisLogRepositoryInterface::class,
            EloquentAiAnalysisLogRepository::class
        );

        $this->app->bind(
            AiAnalysisLogsQueryPort::class,
            AiAnalysisLogsQuery::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
