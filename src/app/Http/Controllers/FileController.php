<?php

namespace ikepu_tp\FileLibrary\app\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use Exception;
use ikepu_tp\FileLibrary\app\Http\Requests\FileRequest;
use ikepu_tp\FileLibrary\app\Http\Resources\FileLibraryResource;
use ikepu_tp\FileLibrary\app\Http\Resources\Resource;
use ikepu_tp\FileLibrary\app\Models\File;
use ikepu_tp\FileLibrary\app\Services\FileLibraryService;
use Illuminate\Support\Facades\Storage;

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
        $files = File::query()
            ->where([
                ["user_id", $user_id],
                ["guard", $guard],
            ]);
        if ($fileRequest->expectsJson()) return Resource::pagination($files, FileLibraryResource::class);
        return view("FileLibrary::lib.index", [
            "files" => $files->paginate($fileRequest->query("per", 10)),
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
        $files = FileLibraryService::upload($guard, $fileRequest->file("files", []), $fileRequest->input("names", []));

        if ($fileRequest->expectsJson()) return Resource::create(FileLibraryResource::collection($files));
        return back()->with("status", __("FileLibrary::file-library.files_saved"));
    }

    /**
     * Display the specified resource.
     */
    public function show(FileRequest $fileRequest, File $file)
    {
        if ($fileRequest->expectsJson()) return Resource::success(new FileLibraryResource($file));
        return response()->file(
            Storage::path($file->path), //ファイルパス
            [ //headers
                "Content-Type" => $file->type,
            ]
        );
    }

    /**
     * ダウンロード
     *
     * @param FileRequest $fileRequest
     * @param File $file
     * @return void
     */
    public function download(FileRequest $fileRequest, File $file)
    {
        $path = Storage::path($file->path);
        $name = $file->name;
        $info = pathinfo($path);
        $ext = $info["extension"];
        $splited_name = explode(".", $name);
        if ($splited_name[count($splited_name) - 1] !== $ext) $name .= ".$ext";

        return response()->download(
            $path, //ファイルパス
            $name, //ダウンロード時のファイル名
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
        $file->fill($fileRequest->safe()->only(["name"]));

        if (!$file->save()) throw new Exception(__("FileLibrary::file-library.failed_save_file"));

        if ($fileRequest->expectsJson()) return Resource::success(new FileLibraryResource($file));
        return back()->with("status", __("FileLibrary::file-library.file_updated"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FileRequest $fileRequest, File $file)
    {
        if (!$file->delete()) throw new Exception(__("FileLibrary::file-library.failed_delete_file"));

        if ($fileRequest->expectsJson()) return response()->noContent();
        return redirect()->route("file-library.index")->with("status", __("FileLibrary::file-library.file_deleted"));
    }
}