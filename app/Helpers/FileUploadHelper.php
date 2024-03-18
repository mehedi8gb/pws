<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadHelper
{
    protected static ?string $filePath;
    protected static ?string $fileName;

    /**
     * @param UploadedFile $file
     * @param string $destination
     * @param string $userId
     * @param string $disk
     * @return void
     */
    public static function uploadFile(UploadedFile $file, string $destination, string $userId, string $disk = 'public'): void
    {
        self::$fileName = $file->getClientOriginalName();
        $filenameUUID = Str::uuid()->toString() . '.' . self::$fileName;
        self::$filePath = $file->storeAs($destination . '/' . $userId, $filenameUUID, $disk);
    }

    public static function deleteFile(string $filePath, string $disk = 'public'): void
    {
        if (Storage::disk($disk)->exists($filePath)) {
            Storage::disk($disk)->delete($filePath);
        }
    }

    /**
     * @return string|null
     */
    public static function getFilePath(): ?string
    {
        return self::$filePath;
    }

    public static function getFileName(): ?string
    {
        return self::$fileName;
    }

}
