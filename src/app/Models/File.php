<?php

namespace ikepu_tp\FileLibrary\app\Models;

/**
 * @property string $fileId
 * @property int $user_id
 * @property string $guard
 * @property string $name
 * @property string $type
 * @property string $path
 */
class File extends Models
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'fileId' => 'string',
        'user_id' => 'integer',
        'guard' => 'string',
        'name' => 'string',
        'type' => 'string',
        'path' => 'string',
    ];

    public function getRouteKey()
    {
        return $this->fileId;
    }
}