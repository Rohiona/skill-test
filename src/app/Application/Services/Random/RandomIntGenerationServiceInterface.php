<?php

namespace App\Application\Services\Random;

use Random\RandomException;

interface RandomIntGenerationServiceInterface
{
    /**
     * @throws RandomException
     */
    public function shouldFail(): bool;

    public function classFrom(string $imagePath): int;

    public function confidenceFrom(string $imagePath): float;
}
