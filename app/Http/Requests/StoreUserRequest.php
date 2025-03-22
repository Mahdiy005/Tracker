<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponseSchema;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreUserRequest extends FormRequest
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
        if($this->is('api/*'))
        {
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
            'email' => 'required|email|string|unique:users,email',
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'phone' => 'nullable|max:11',
            'password' => 'required|string|confirmed|min:8',
            'position' => 'required|string',
        ];
    }
}
