<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiaryEntryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'review_id' => ['nullable', 'integer'],
            'reread' => ['required', 'boolean'],
            'spoilers' => ['required', 'boolean'],
            'liked' => ['required', 'boolean'],
            'read_on' =>  ['required', 'date']
        ];
    }
}
