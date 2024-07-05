<?php

namespace App\Helpers;

use Exception;
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

    /**
     * @throws Exception
     */
    public static function uploadFileFromBase64(string $base64File, string $destination, string $userId, string $fileExtension = 'png', string $disk = 'public'): void
    {
        // Decode base64 file
        $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64File));

        if ($fileData === false) {
            throw new Exception('Base64 decode failed');
        }

        // Generate unique file name
        self::$fileName = Str::uuid()->toString() . '.' . $fileExtension;
        self::$filePath = $destination . '/' . $userId . '/' . self::$fileName;

        // Save the file
        Storage::disk($disk)->put(self::$filePath, $fileData);
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
