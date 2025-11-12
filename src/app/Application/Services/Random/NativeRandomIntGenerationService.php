<?php

namespace App\Application\Services\Random;

final class NativeRandomIntGenerationService implements RandomIntGenerationServiceInterface
{
    public function shouldFail(): bool
    {
        // 1〜100 の整数を振り、25 以下なら失敗と判定する。
        $roll = random_int(1, 100); // 1 から 100 の乱数値を取得

        return $roll <= 25; // 25 以下なら 25% の確率で true（失敗）
    }

    public function classFrom(string $imagePath): int
    {
        // パス文字列から crc32 ハッシュを算出し、1〜10 のクラスにマッピングする。
        $normalized = trim($imagePath); // 余分な空白を除去
        $hash = crc32($normalized); // CRC32 で 32bit のハッシュ値を得る
        $classIndex = $hash % 10; // 下位10通り(0〜9)に圧縮

        return $classIndex + 1; // クラスは 1〜10 なので +1 する
    }

    public function confidenceFrom(string $imagePath): float
    {
        // CRC32 の別ビット領域を使い、0.8500〜0.9999 の範囲に正規化した擬似信頼度を導き出す。
        // こうすることでパスが同じなら信頼度も再現性を持つ。
        $normalized = trim($imagePath);
        // CRC32 で同じパスなら同じ値を取得
        $hash = crc32($normalized);
        // ハッシュを 8bit 右シフトし 0〜9999 に正規化
        $range = ($hash >> 8) % 10000;
        // 0.85〜1.0 へスケール変換
        $confidence = 0.85 + ($range / 9999) * 0.15;
        // 1.0 を超えないように上限を設定
        $bounded = min($confidence, 0.9999);

        return round($bounded, 4); // 小数第4位まで表示
    }
}
