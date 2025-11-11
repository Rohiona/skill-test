<?php

namespace App\Application\Gateways;

use App\Application\DTO\ImageClassifyResult;

interface ImageClassificationPort
{
    public function classify(string $imagePath): ImageClassifyResult;
}
