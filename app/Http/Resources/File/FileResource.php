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
        $id = $this->id;
        return [
            'file_path' => url('storage/'.$this->file_path),
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y'),
//            'links' => [
//                'delete' => route('file.destroy', $id),
//            ]
        ];
    }
}
