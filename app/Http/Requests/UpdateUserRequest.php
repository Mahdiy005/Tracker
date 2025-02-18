<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponseSchema;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return TRUE;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*')) {
            $response = ApiResponseSchema::sendResponse(422, 'Validation Error', $validator->errors());
            throw new ValidationException($validator, $response);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|string',
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'phone' => 'required|max:11',
            'position' => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return [
            //'name' => 'Name',
        ];
    }
}
