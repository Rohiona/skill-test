<?php

namespace App\Application\Support;

use Random\RandomException;

interface RandomIntGeneratorInterface
{
    /**
     * @throws RandomException
     */
    public function shouldFail(): bool;

    public function classFrom(string $imagePath): int;

    public function confidenceFrom(string $imagePath): float;
}
