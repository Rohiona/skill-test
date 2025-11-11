<?php

namespace App\Application\Input;

final class AnalyzeImageInput
{
    public function __construct(
        public readonly string $imagePath,
    ) {}
}
