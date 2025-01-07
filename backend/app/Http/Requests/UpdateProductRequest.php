<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateProductRequest extends FormRequest
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
            'name'  => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg|max:200',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'categories' => 'required|array|exists:categories,id'
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Name is required.",
            "name.string" => "Name must be a string.",
            "name.max" => "Name is too long. Maximum length is 255 characters",
            "image.required" => "Image is required.",
            "image.image" => "Image must be an image.",
            "image.mimes" => "Image must be a JPEG, PNG, or JPG.",
            "image.max" => "Image size is too large. Maximum size is 200KB.",
            "price.required" => "Price is required.",
            "price.numeric" => "Price must be a number.",
            "price.min" => "Price must be at least 0.",
            "price.max" => "Price must be less than or equal to 99999999.99.",
            "categories.required" => "Categories are required.",
            "categories.array" => "Categories must be an array.",
            "categories.exists" => "Selected category does not exist."
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
