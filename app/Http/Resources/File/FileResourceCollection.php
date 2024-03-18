<?php
namespace App\Http\Resources\File;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FileResourceCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => FileResource::collection($this->collection),
        ];
    }
}
        