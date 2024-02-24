<?php

namespace ikepu_tp\FileLibrary\app\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use Exception;
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
        $guard = config("file-library.guard");
        /** @var \Illuminate\Foundation\Auth\User */
        $user = $fileRequest->user($guard);
        $user_id = $user->getKey();
        return view("FileLibrary::lib.index", [
            "files" => File::query()
                ->where("user_id", $user_id)
                ->paginate($fileRequest->query("per", 10))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(FileRequest $fileRequest)
    {
        return view("FileLibrary::lib.create");
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
        /** @var bool */
        $upload_failed = false;
        /** @var \Illuminate\Http\UploadedFile[] */
        $files = $fileRequest->file("files", []);
        /** @var string[] */
        $names = $fileRequest->input("names", []);
        /** @var File[] */
        $saved_files = [];
        foreach ($files as $idx => $upfile) {
            $file_model = new File();
            $fileId = Str::uuid();
            $path = config("file-library.path", "");
            $name = $fileId . "." . $upfile->getClientOriginalExtension();;
            $file_model->fill([
                "fileId" => $fileId,
                "user_id" => $user_id,
                "guard" => $guard,
                "name" => isset($names[$idx]) ? $names[$idx] : "",
                "type" => $upfile->getClientMimeType(),
                "path" => "{$path}/{$name}",
            ]);
            if (!$upfile->storeAs($path, $name) || !$file_model->save()) {
                $upload_failed = true;
            } else {
                $saved_files[] = $file_model;
            }
        }

        if ($upload_failed) throw new Exception("Upload failed.");

        if ($fileRequest->expectsJson()) return $saved_files;
        return back()->with("status", "Files saved.");
    }

    /**
     * Display the specified resource.
     */
    public function show(FileRequest $fileRequest, File $file)
    {
        return response()->file(
            Storage::path($file->path), //ファイルパス
            [ //headers
                "Content-Type" => $file->type,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FileRequest $fileRequest, File $file)
    {
        return view("FileLibrary::lib.edit", [
            "file" => $file,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FileRequest $fileRequest, File $file)
    {
        $file->fill($fileRequest->only(["name"]));

        if (!$file->save()) throw new Exception("Failed to save file.");

        if ($fileRequest->expectsJson()) return $file;
        return back()->with("status", "File updated.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FileRequest $fileRequest, File $file)
    {
        if (!$file->delete()) throw new Exception("Failed to delete file.");

        if ($fileRequest->expectsJson()) return response()->noContent();
        return back()->with("status", "File deleted.");
    }
}