<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PosterUpdateRequest extends FormRequest
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
            'hashtags' => 'required|array',
            'hashtags.*' => 'required|integer|min:1',
            'title'       => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price'       => 'sometimes|integer|min:0|max:99999999999999.99',
            'rooms'       => 'sometimes|integer|min:0',
            'bathrooms'   => 'sometimes|integer|min:0',
            'area'        => 'sometimes|integer|min:0',
            'type'        => ['sometimes', Rule::in(['sale', 'rent'])],
            'furnished'   => 'boolean',
            'garage'      => 'boolean',
            'negotiable'      => 'boolean',
            'status'      => 'boolean',
            'images' => ['sometimes', 'string', 'regex:/^data:image\/(jpeg|png|jpg|gif);base64,.+/'],
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