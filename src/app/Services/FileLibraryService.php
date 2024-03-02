<?php

namespace ikepu_tp\FileLibrary\app\Services;

use Exception;
use ikepu_tp\FileLibrary\app\Models\File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FileLibraryService extends Service
{

    /**
     * ファイルのアップロード
     *
     * @param string $guard
     * @param UploadedFile[] $files
     * @param string[] $names
     * @return Collection<,File>
     */
    static public function upload(string $guard, array $files, array $names): Collection
    {
        /** @var User */
        $user = Auth::guard($guard)->user();
        $user_id = $user->getKey();
        /** @var bool */
        $upload_failed = false;
        /** @var int[] */
        $saved_files = [];
        foreach ($files as $idx => $upfile) {
            $file_model = new File();
            $fileId = Str::uuid();

            //アップロードファイル関係
            $ext = $upfile->getClientOriginalExtension();
            $filename = $fileId . "." . $ext;
            $path = config("file-library.path", "");

            //ファイル名の確認
            $name = isset($names[$idx]) ? $names[$idx] : "";

            $file_model->fill([
                "fileId" => $fileId,
                "user_id" => $user_id,
                "guard" => $guard,
                "name" => $name,
                "type" => $upfile->getClientMimeType(),
                "path" => "$path/$filename",
            ]);
            if (
                !$upfile->storeAs($path, $filename, config("file-library.disk")) ||
                !$file_model->save()
            ) {
                $upload_failed = true;
            } else {
                $saved_files[] = $file_model->id;
            }
        }

        if ($upload_failed) throw new Exception(__("FileLibrary::file-library.failed_upload_files"));

        return File::query()
            ->whereIn("id", $saved_files)
            ->get();
    }
}
