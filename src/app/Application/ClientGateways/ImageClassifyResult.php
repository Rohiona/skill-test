<?php

namespace App\Application\ClientGateways;

final class ImageClassifyResult
{
    public function __construct(
        public readonly bool $success,
        public readonly ?int $class,
        public readonly ?float $confidence,
        public readonly string $message
    ) {}
}
