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
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @group File Management
     * @queryParam order_id required_without:session_id The ID of the order. Example: 1
     * @queryParam file_type required The type of the file. Example: invoice
     * @queryParam session_id required_without:order_id The session ID. Example: abc123
     * @response 200 {
     *  "data": [
     *    {
     *      "id": 1,
     *      "user_id": 1,
     *      "order_id": 1,
     *      "file_name": "example.pdf",
     *      "file_path": "path/to/example.pdf",
     *      "file_type": "invoice"
     *    }
     *  ]
     * }
     */
    public function index(Request $request): FileResourceCollection
    {
        $request->validate([
            'order_id' => 'required_without:session_id',
            'file_type' => 'required',
            'session_id' => 'required_without:order_id'
        ]);
        $files = [];

        if ($request->has('order_id')) {
            $files = File::where('order_id', $request->order_id)
                ->where('file_type', $request->file_type)->get();
        }
        if ($request->has('session_id')) {
            $files = File::where('session_id', $request->session_id)
                ->where('file_type', $request->file_type)->get();
        }

        return FileResourceCollection::make($files);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @group File Management
     * @bodyParam user_id int required The ID of the user. Example: 1
     * @bodyParam order_id int required The ID of the order. Example: 1
     * @bodyParam file_type string required The type of the file. Example: invoice
     * @bodyParam files array The files to be uploaded.
     * @bodyParam base64_files array The base64 encoded files to be uploaded.
     * @response 201 {
     *  "success": true,
     *  "message": "invoice files uploaded successfully"
     * }
     * @response 400 {
     *  "success": false,
     *  "message": "No file uploaded"
     * }
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

        if (count($validatedData['base64_files']) > 0) {
            foreach ($validatedData['base64_files'] as $base64File) {
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

    /**
     * Temporarily store a newly created resource in storage.
     *
     * @group File Management
     * @bodyParam session_id string required The session ID. Example: abc123
     * @bodyParam file_type string required The type of the file. Example: invoice
     * @bodyParam files array The files to be uploaded.
     * @bodyParam base64_files array The base64 encoded files to be uploaded.
     * @response 201 {
     *  "success": true,
     *  "message": "invoice files uploaded temporarily with session ID"
     * }
     * @response 400 {
     *  "success": false,
     *  "message": "No file uploaded"
     * }
     */
    public function tempStore(FileStoreRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $sessionId = $validatedData['session_id'];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                FileUploadHelper::uploadFile($file, $validatedData['file_type'], 'temp');

                $data = File::create([
                    'session_id' => $sessionId,
                    'file_name' => FileUploadHelper::getFileName(),
                    'file_path' => FileUploadHelper::getFilePath(),
                    'file_type' => $validatedData['file_type'],
                ]);
                $data->save();
            }
            return response()->json([
                'success' => true,
                'message' => $validatedData['file_type'] . ' files uploaded temporarily with session ID',
            ], Response::HTTP_CREATED);
        }

        if (count($validatedData['base64_files']) > 0) {
            foreach ($validatedData['base64_files'] as $base64File) {
                FileUploadHelper::uploadFileFromBase64($base64File, $validatedData['file_type'], 'temp');

                $data = File::create([
                    'session_id' => $sessionId,
                    'file_name' => FileUploadHelper::getFileName(),
                    'file_path' => FileUploadHelper::getFilePath(),
                    'file_type' => $validatedData['file_type'],
                ]);
                $data->save();
            }
            return response()->json([
                'success' => true,
                'message' => $validatedData['file_type'] . ' base64 files uploaded temporarily with session ID',
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded',
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @group File Management
     * @urlParam fileId int required The ID of the file. Example: 1
     * @response 200 {
     *  "data": {
     *    "id": 1,
     *    "user_id": 1,
     *    "order_id": 1,
     *    "file_name": "example.pdf",
     *    "file_path": "path/to/example.pdf",
     *    "file_type": "invoice"
     *  }
     * }
     * @response 404 {
     *  "message": "Not Found"
     * }
     */
    public function show($fileId): FileResource
    {
        $file = File::find($fileId);

        return FileResource::make($file);
    }

    /**
     * Move files to permanent storage.
     *
     * @group File Management
     * @bodyParam session_id string required The session ID. Example: abc123
     * @bodyParam order_id int required The ID of the order. Example: 1
     * @bodyParam user_id int required The ID of the user. Example: 1
     * @bodyParam file_type string required The type of the file. Example: invoice
     * @response 200 {
     *  "success": true,
     *  "message": "Files moved to permanent storage successfully"
     * }
     * @response 400 {
     *  "success": false,
     *  "message": "Validation error"
     * }
     */
    public function moveToPermanent(Request $request): JsonResponse
    {
        $request->validate([
            'session_id' => 'required',
            'order_id' => 'required',
            'user_id' => 'required',
            'file_type' => 'required',
        ]);

        $files = File::where('session_id', $request->session_id)->get();
        foreach ($files as $file) {
            $filepath = FileUploadHelper::moveFileToPermanent($file, $request->user_id);
            $file->update([
                'user_id' => $request->user_id,
                'order_id' => $request->order_id,
                'file_path' => $filepath,
                'session_id' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Files moved to permanent storage successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @group File Management
     * @urlParam file int required The ID of the file. Example: 1
     * @bodyParam user_id int The ID of the user. Example: 1
     * @bodyParam order_id int The ID of the order. Example: 1
     * @bodyParam file_type string The type of the file. Example: invoice
     * @response 200 {
     *  "data": {
     *    "id": 1,
     *    "user_id": 1,
     *    "order_id": 1,
     *    "file_name": "example.pdf",
     *    "file_path": "path/to/example.pdf",
     *    "file_type": "invoice"
     *  }
     * }
     * @response 400 {
     *  "message": "Validation error"
     * }
     */
    public function update(FileUpdateRequest $request, File $file): FileResource
    {
        $file->update($request->validated());
        return FileResource::make($file);
    }

    /**
     * Download the specified resource.
     *
     * @group File Management
     * @urlParam file int required The ID of the file. Example: 1
     * @response 200 application/octet-stream The file download.
     * @response 404 {
     *  "message": "Not Found"
     * }
     */
    public function download(File $file, Request $request)
    {
        $filePath = storage_path('app/public/' . $file->file_path);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @group File Management
     * @urlParam file int required The ID of the file. Example: 1
     * @response 204 {
     *  "success": true,
     *  "message": "File deleted successfully"
     * }
     * @response 404 {
     *  "message": "Not Found"
     * }
     */
    public function destroy(File $file): JsonResponse
    {
        $file->delete();
        FileUploadHelper::deleteFile($file->file_path);

        return response()->json([
            'success' => true,
            'message' => 'File deleted successfully'
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Validate the access token.
     *
     * @group File Management
     * @param string $accessToken The access token to validate.
     * @return bool
     */
    private function isValidAccessToken($accessToken)
    {
        return $accessToken === 'YOUR_SECRET_ACCESS_TOKEN';
    }
}
