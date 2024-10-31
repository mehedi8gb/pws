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
            'file_type' => 'required|in:avatar,artwork', // Define allowed file types
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

    public function bodyParameters(): array
    {
        return [
            'user_id' => [
                'description' => 'The ID of the user.',
                'example' => 1,
            ],
            'order_id' => [
                'description' => 'The ID of the order.',
                'example' => 1,
            ],
            'session_id' => [
                'description' => 'The session ID.',
                'example' => '53fc529b-f438-49cc-8e42-959400cbd1c1',
            ],
            'file_type' => [
                'description' => 'The type of the file.',
                'example' => 'invoice',
            ],
            'files' => [
                'description' => 'The files to be uploaded.',
                'example' => [],
            ],
            'base64_files' => [
                'description' => 'The base64 encoded files to be uploaded.',
                'example' => [],
            ],
        ];
    }
}
