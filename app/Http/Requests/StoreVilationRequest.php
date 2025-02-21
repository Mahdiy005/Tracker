<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponseSchema;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreVilationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return TRUE;
    }

    // schema validation form
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
            'violation_type' => 'required|string',
            'violation_image' => 'nullable',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'user_id' => 'User',
        ];
    }
}
