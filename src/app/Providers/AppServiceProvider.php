<?php

namespace App\Providers;

use App\Application\ClientGateways\AiAnalysisGateway;
use App\Application\QueryPorts\AiAnalysis\Index\AiAnalysisLogsQueryPort;
use App\Application\Services\Random\NativeRandomIntGenerationService;
use App\Application\Services\Random\RandomIntGenerationServiceInterface;
use App\Domain\AiAnalysisLog\Repositories\AiAnalysisLogRepositoryInterface;
use App\Infrastructure\Api\MockAiAnalysisGatewayClient;
use App\Infrastructure\Persistence\AiAnalysis\EloquentAiAnalysisLogRepository;
use App\Infrastructure\Queries\AiAnalysis\Index\AiAnalysisLogsQuery;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RandomIntGenerationServiceInterface::class, NativeRandomIntGenerationService::class);

        $this->app->bind(AiAnalysisGateway::class, MockAiAnalysisGatewayClient::class);

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
