<?php

namespace App\Infrastructure\Api;

use App\Application\ClientGateways\ImageClassificationGateway;
use App\Application\ClientGateways\ImageClassifyResult;
use App\Application\Support\RandomIntGeneratorInterface;
use Random\RandomException;

final class MockImageClassificationClient implements ImageClassificationGateway
{
    public function __construct(private readonly RandomIntGeneratorInterface $random) {}

    /**
     * @throws RandomException
     */
    public function classify(string $imagePath): ImageClassifyResult
    {
        if ($this->random->shouldFail()) {
            return $this->failureResult();
        }

        return new ImageClassifyResult(
            success: true,
            class: $this->random->classFrom($imagePath),
            confidence: $this->random->confidenceFrom($imagePath),
            message: 'success'
        );
    }

    private function failureResult(): ImageClassifyResult
    {
        return new ImageClassifyResult(
            success: false,
            class: null,
            confidence: null,
            message: 'Error:E50012'
        );
    }
}
