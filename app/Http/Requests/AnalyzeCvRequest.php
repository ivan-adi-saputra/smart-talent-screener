<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponse;

class AnalyzeCvRequest extends FormRequest
{
    use ApiResponse;
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:2048',
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
