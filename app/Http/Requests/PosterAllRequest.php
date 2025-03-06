<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PosterAllRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sort_by' => ['required', Rule::in(['title', 'price', 'created_at', 'random'])],
            'order_by' => ['required', Rule::in(['asc', 'desc'])],
            'region_id' => ['nullable', 'exists:regions,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'subcategory_id' => ['nullable', 'exists:categories,id'],
            'min_price' => ['nullable', 'numeric', 'min:1'],
            'max_price' => ['nullable', 'numeric', 'gt:min_price'],
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422));
    }
}