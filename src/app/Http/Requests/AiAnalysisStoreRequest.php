<?php

namespace App\Http\Requests;

use App\Application\UseCases\AiAnalysis\AnalyzeImageUseCaseInput;
use App\Application\ValueObjects\ImagePath;
use Illuminate\Foundation\Http\FormRequest;
use InvalidArgumentException;

final class AiAnalysisStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image_path' => [
                'required',
                'string',
                function (string $attribute, mixed $value, callable $fail): void {
                    try {
                        ImagePath::fromString((string) $value);
                    } catch (InvalidArgumentException $e) {
                        $fail($e->getMessage());
                    }
                },
            ],
        ];
    }

    public function getAnalyzeImageInput(): AnalyzeImageUseCaseInput
    {
        $imagePath = ImagePath::fromString($this->validated('image_path'));

        return new AnalyzeImageUseCaseInput($imagePath->value());
    }
}
