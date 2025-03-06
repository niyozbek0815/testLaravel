<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PosterStoreRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'region_id'   => 'required|exists:regions,id',
            'hashtags' => 'required|array',
            'hashtags.*' => 'required|integer|min:1',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|integer|min:0|max:99999999999999.99',
            'rooms'       => 'nullable|integer|min:0',
            'bathrooms'   => 'nullable|integer|min:0',
            'area'        => 'required|integer|min:0',
            'type'        => ['required', Rule::in(['sale', 'rent'])],
            'furnished'   => 'required|boolean',
            'negotiable'   => 'required|boolean',
            'garage'      => 'required|boolean',
            'images' => ['required', 'string', 'regex:/^data:image\/(jpeg|png|jpg|gif);base64,.+/'],
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
