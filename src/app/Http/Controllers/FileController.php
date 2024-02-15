<?php

namespace ikepu_tp\FileLibrary\app\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use ikepu_tp\FileLibrary\app\Http\Requests\FileRequest;
use ikepu_tp\FileLibrary\app\Models\File;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(FileRequest $fileRequest)
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(FileRequest $fileRequest)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FileRequest $fileRequest)
    {
        $guard = config("file-library.guard");
        /** @var \Illuminate\Foundation\Auth\User */
        $user = $fileRequest->user($guard);
        $user_id = $user->getKey();
        /** @var \Illuminate\Http\UploadedFile[] */
        $files = $fileRequest->file("files", []);
        /** @var string[] */
        $names = $fileRequest->input("names", []);
        foreach ($files as $idx => $file) {
            $file_model = new File();
            $fileId = Str::uuid();
            $path = config("file-library.path", "") . $fileId;
            $file_model->fill([
                "fileId" => $fileId,
                "user_id" => $user_id,
                "guard" => $guard,
                "name" => isset($names[$idx]) ? $names[$idx] : "",
                "type" => "",
                "path" => $path,
            ]);
            Storage::putFileAs($path, $file);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FileRequest $fileRequest, File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FileRequest $fileRequest, File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FileRequest $fileRequest, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FileRequest $fileRequest, File $file)
    {
        //
    }
}