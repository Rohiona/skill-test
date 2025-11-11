<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AnalyzeImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image_path' => ['required', 'string', 'max:255'],
        ];
    }
}
