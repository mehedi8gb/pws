<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;

class FileStoreRequest extends FormRequest
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
            'files' => 'required|max:102400', // Assuming 100MB file size limit (can be adjusted)
            'user_id' => 'required',
            'file_type' => 'required|in:avatar,cv_cover_image', // Define allowed file types
        ];
    }

    public function messages(): array
    {
        return [
            'files.required' => 'The files field is required.',
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
