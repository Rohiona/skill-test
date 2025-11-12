<?php

namespace App\Domain\AiAnalysisLog\Repositories;

interface AiAnalysisLogRepositoryInterface
{
    public function create(array $data): void;
}
