<?php

namespace App\Application\ClientGateways;

interface ImageClassificationGateway
{
    public function classify(string $imagePath): ImageClassifyResult;
}
