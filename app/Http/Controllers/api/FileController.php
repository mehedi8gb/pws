<?php

namespace App\Http\Controllers\api;

use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileStoreRequest;
use App\Http\Requests\File\FileUpdateRequest;
use App\Http\Resources\File\FileResource;
use App\Http\Resources\File\FileResourceCollection;
use App\Models\File;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    // Display a listing of the resource.
    public function index(Request $request): FileResourceCollection
    {
        $request->validate([
            'order_id' => 'required',
            'file_type' => 'required',
        ]);

        $files = File::where('order_id', $request->order_id)
            ->where('file_type', $request->file_type)->get();

        return FileResourceCollection::make($files);
    }

    // Store a newly created resource in storage.

    /**
     * @throws Exception
     */
    public function store(FileStoreRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                FileUploadHelper::uploadFile($file, $validatedData['file_type'], $validatedData['user_id']);

                $data = File::create([
                    'user_id' => $validatedData['user_id'],
                    'order_id' => $validatedData['order_id'],
                    'file_name' => FileUploadHelper::getFileName(),
                    'file_path' => FileUploadHelper::getFilePath(),
                    'file_type' => $validatedData['file_type'],
                ]);
                $data->save();
            }
            return response()->json([
                'success' => true,
                'message' => $validatedData['file_type'] . ' files uploaded successfully',
            ], Response::HTTP_CREATED);
        }

        // Check if the request contains base64 encoded images
        if (count($validatedData['base64_files']) > 0) {
            foreach ($validatedData['base64_files'] as $base64File) {
                // Assuming FileUploadHelper is adjusted to support base64 files
                if (FileUploadHelper::isValidBase64($base64File)) {
                    FileUploadHelper::uploadFileFromBase64($base64File, $validatedData['file_type'], $validatedData['user_id']);

                    $data = File::create([
                        'user_id' => $validatedData['user_id'],
                        'order_id' => $validatedData['order_id'],
                        'file_name' => FileUploadHelper::getFileName(),
                        'file_path' => FileUploadHelper::getFilePath(),
                        'file_type' => $validatedData['file_type'],
                    ]);
                    $data->save();
                }
            }
            return response()->json([
                'success' => true,
                'message' => $validatedData['file_type'] . ' base64 files uploaded successfully',
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded',
        ], Response::HTTP_BAD_REQUEST);
    }

    // Display the specified resource.
    public function show($fileId)
    {
        $file = File::find($fileId);
        return FileResource::make($file);
    }

    // Update the specified resource in storage.
    public function update(FileUpdateRequest $request, File $file)
    {
        $file->update($request->validated());
        return FileResource::make($file);
    }

    // Download the specified resource.
    public function download(File $file, Request $request)
    {
        // $accessToken = $request->header('Authorization');

        // if (!$this->isValidAccessToken($accessToken)) {
        //     abort(401, 'Unauthorized');
        // }
        $filePath = storage_path('app/public/' . $file->file_path);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        abort(404);
    }

    // Remove the specified resource from storage.
    public function destroy(File $file)
    {
        $file->delete();
        FileUploadHelper::deleteFile($file->file_path);

        return response()->json([
            'success' => true,
            'message' => 'File deleted successfully'
        ], Response::HTTP_NO_CONTENT);
    }

    // Validate the access token
    private function isValidAccessToken($accessToken)
    {
        // Implement your logic to validate the access token
        // For example, check against your database or another source
        return $accessToken === 'YOUR_SECRET_ACCESS_TOKEN';
    }
}
