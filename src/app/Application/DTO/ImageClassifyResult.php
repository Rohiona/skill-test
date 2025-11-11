<?php

namespace App\Application\DTO;

final class ImageClassifyResult
{
    public function __construct(
        public readonly bool $success,
        public readonly ?int $class,
        public readonly ?float $confidence,
        public readonly string $message
    ) {}
}
