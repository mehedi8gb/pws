<?php

namespace App\Http\Requests\File;

use App\Rules\Base64Image;
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
            'user_id' => 'required',
            'order_id' => 'required',
            'file_type' => 'required|in:invoice,customer,artwork,item_file', // Define allowed file types
            'files' => 'required_without:base64_files|array', // 'files' should be an array if provided
            'files.*' => 'file|max:102400', // Validate each file in 'files' array
            'base64_files' => 'required_without:files|array', // 'base64_files' should be an array if provided
            'base64_files.*' => 'string', // Each entry in 'base64_files' should be a string
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'The user ID field is required.',
            'order_id.required' => 'The order ID field is required.',
            'file_type.required' => 'The file type field is required.',
            'file_type.in' => 'The selected file type is invalid.',
            'files.required_without' => 'The files field is required when base64 files are not present.',
            'files.array' => 'The files must be an array.',
            'files.*.file' => 'Each file must be a valid file.',
            'files.*.max' => 'Each file may not be greater than 100MB.',
            'base64_files.required_without' => 'The base64 files field is required when files are not present.',
            'base64_files.array' => 'The base64 files must be an array.',
            'base64_files.*.string' => 'Each base64 file must be a valid string.',
        ];
    }

    public function attributes(): array
    {
        return [
            'files' => 'uploaded files',
            'base64_files' => 'base64 encoded files',
        ];
    }


    protected function passedValidation(): void
    {
        $this->replace([
            //
        ]);
    }
}
