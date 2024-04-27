<?php

namespace App\Http\Resources\File;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

class FileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'file_name' => $this->file_name,
            'file_path' => $this->file_path,
            'file_url' => route('file.download', $this->id),
            'editMode' => false,
            'showDeleteWarning' => false,
            'created_at' => Carbon::parse($this->created_at)->format('d M Y'),
        ];
    }
}
