<?php

namespace App\Application\ValueObjects;

use InvalidArgumentException;

final class ImagePath
{
    private const MAX_LENGTH = 255;

    /** @var string[] */
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];

    private function __construct(private readonly string $value) {}

    public static function fromString(string $rawPath): self
    {
        $path = trim($rawPath);

        if ($path === '') {
            throw new InvalidArgumentException('画像パスが空です。');
        }

        if (strlen($path) > self::MAX_LENGTH) {
            throw new InvalidArgumentException('画像パスが長すぎます（255文字以内）。');
        }

        if (!str_starts_with($path, '/')) {
            throw new InvalidArgumentException('画像パスは / から始まる必要があります。');
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (!in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            throw new InvalidArgumentException("許可されていない拡張子です: .{$extension}");
        }

        if (!preg_match('#^/[A-Za-z0-9_\-/]+\.[A-Za-z0-9]+$#', $path)) {
            throw new InvalidArgumentException('画像パスの形式が正しくありません。');
        }

        return new self($path);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
