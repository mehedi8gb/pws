<?php

namespace App\Http\Controllers\api;

use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileStoreRequest;
use App\Http\Requests\File\FileUpdateRequest;
use App\Http\Resources\File\FileResource;
use App\Http\Resources\File\FileResourceCollection;
use App\Models\File;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    // Display a listing of the resource.
    public function index(Request $request)
    {
        $files = File::where([
            ['user_id', $request->user_id],
            ['order_id', $request->order_id],
        ])->get();

        return FileResourceCollection::make($files);
    }

    // Store a newly created resource in storage.
    public function store(FileStoreRequest $request)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                FileUploadHelper::uploadFile($file, $validatedData['file_type'], $validatedData['user_id']);

                $data = File::create([
                    'user_id' => $validatedData['user_id'],
                    'order_id' => $validatedData['order_id'],
                    'file_type' => $validatedData['file_type'],
                    'file_path' => FileUploadHelper::getFilePath(),
                ]);
                $data->save();
            }
            return response()->json([
                'success' => true,
                'message' => $validatedData['file_type'] . ' files uploaded successfully',
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

    // Remove the specified resource from storage.
    public function destroy(File $file)
    {
        $file->delete();

        return response()->json([
            'success' => true,
            'message' => 'File deleted successfully'
        ], Response::HTTP_NO_CONTENT);
    }
}
