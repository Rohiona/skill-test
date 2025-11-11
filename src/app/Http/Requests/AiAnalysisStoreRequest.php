<?php

namespace App\Http\Requests;

use App\Application\Input\AnalyzeImageInput;
use Illuminate\Foundation\Http\FormRequest;

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
                'max:255',
                'regex:/^\/[A-Za-z0-9_\-\/]+\.(jpe?g|png|gif|bmp|webp)$/i',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'image_path.regex' => '画像パスは /xxx/yyy.jpg の形式で入力してください。',
        ];
    }

    public function getAnalyzeImageInput(): AnalyzeImageInput
    {
        return new AnalyzeImageInput($this->validated()['image_path']);
    }
}
