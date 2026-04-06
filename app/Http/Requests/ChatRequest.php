<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\ValidationRule;

class ChatRequest extends FormRequest
{
    use ApiResponse;
    
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'candidate_id' => 'required|exists:candidates,id',
            'message' => 'required|string',
        ];
    }

    /**
     * Override method failedValidation
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        $firstErrorMessage = $validator->errors()->first();

        throw new HttpResponseException(
            $this->error(
                $firstErrorMessage ?: 'Validation failed. Please ensure the CV file is in the correct format.', 
                422, 
                $errors,
                false
            )
        );
    }
}
