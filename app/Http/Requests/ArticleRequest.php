<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'organizer_id' => 'required|integer',
            'title' => 'required|string',
            'content' => 'required|string',
            'status' => 'required|string',
            // 'genres' => 'required|array',
            // 'genres.*' => 'integer',
            // 'translations' => 'required|array',
            // 'translations.*.language_id' => 'required|integer',
            // 'translations.*.title' => 'required|string',
            // 'translations.*.content' => 'required|string',
            // 'images' => 'required|array',
            // 'images.*.path' => 'required|string',
        ];
    }
}
