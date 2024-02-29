<?php

namespace ikepu_tp\FileLibrary\app\Http\Resources;

use ikepu_tp\FileLibrary\app\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property File $resource
 */
class FileLibraryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->createArray();
    }

    /**
     * 配列レスポンス作成
     *
     * @return array
     */
    public function createArray(): array
    {
        /**
         * JSON配列
         *
         * {
         *   "fileId": "string",
         *   "name": "string",
         *   "url": "string",
         *   "mime_type": "string",
         *   "created_at": "string",
         *   "updated_at": "string"
         * }
         */
        if (!$this->resource) return [
            "fileId" => "",
            "name" => "",
            "url" => "",
            "mime_type" => "",
            "created_at" => "",
            "updated_at" => "",
        ];

        return [
            "fileId" => $this->resource->fileId,
            "name" => $this->resource->name,
            "url" => route("file-library.show", ["file" => $this->resource]),
            "mime_type" => $this->resource->type,
            "created_at" => $this->resource->created_at,
            "updated_at" => $this->resource->updated_at,
        ];
    }
}