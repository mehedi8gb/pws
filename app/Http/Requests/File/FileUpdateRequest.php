<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;

class FileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization logic goes here (e.g., check if the user has permission)
    }

    protected function prepareForValidation(): void
    {
        // You can perform data manipulation here
    }

    public function rules(): array
    {
        return [
            'files' => 'required|file|max:10240', // Assuming 10MB file size limit (can be adjusted)
            'user_id' => 'required',
            'order_id' => 'required',
            'file_type' => 'required|in:invoice,customer,artwork', // Define allowed file types
        ];
    }

    public function messages(): array
    {
        return [
            'files.required' => 'The file field is required.',
            // Define custom validation error messages here
        ];
    }

    public function attributes(): array
    {
        return [
            //'title' => 'Post title',
        ];
    }

    protected function passedValidation(): void
    {
        $this->replace([
            //
        ]);
    }
}
