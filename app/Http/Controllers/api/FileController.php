<?php

namespace App\Http\Controllers\api;

use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileStoreRequest;
use App\Http\Requests\File\FileUpdateRequest;
use App\Http\Resources\File\FileResource;
use App\Http\Resources\File\FileResourceCollection;
use App\Models\File;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        return FileResourceCollection::make((File::get()));
    }

    // Store a newly created resource in storage.
    public function store(FileStoreRequest $request)
    {
        $validatedData = $request->validated();

        switch ($validatedData['file_type']) {
            case 'invoice':
                FileUploadHelper::uploadFile($request->file('file'), 'invoices', $validatedData['user_id']);
                break;
            case 'customer':
                FileUploadHelper::uploadFile($request->file('file'), 'customer', $validatedData['user_id']);
                break;
            case 'artwork':
                FileUploadHelper::uploadFile($request->file('file'), 'artwork', $validatedData['user_id']);
                break;
            default:
                break;
        }

        $file = File::create([
            'file_type' => $validatedData['file_type'],
            'user_id' => $validatedData['user_id'],
            'order_id' => $validatedData['order_id'],
            'file_path' => FileUploadHelper::getFilePath(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'File uploaded successfully',
            'data' => FileResource::make($file)
        ], Response::HTTP_CREATED);
    }

    // Display the specified resource.
    public function show($slug)
    {
        $file = File::where('slug', $slug)->firstOrFail();
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
