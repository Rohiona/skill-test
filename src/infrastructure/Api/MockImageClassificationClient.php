<?php

namespace App\Infrastructure\Api;

use App\Application\ClientGateways\ImageClassificationGateway;
use App\Application\ClientGateways\ImageClassifyResult;
use Random\RandomException;

final class MockImageClassificationClient implements ImageClassificationGateway
{
    /**
     * @throws RandomException
     */
    public function classify(string $imagePath): ImageClassifyResult
    {
        $normalized = trim($imagePath);

        if (random_int(1, 100) <= 25) {
            return $this->failureResult();
        }

        $hash = crc32($normalized);
        $class = ($hash % 10) + 1; // class range: 1-10
        $confidence = round((($hash >> 8) % 10000) / 10000, 4);

        return new ImageClassifyResult(
            success: true,
            class: $class,
            confidence: $confidence,
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
