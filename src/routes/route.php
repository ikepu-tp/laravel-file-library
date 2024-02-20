<?php

use ikepu_tp\FileLibrary\app\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

$middleware = config("file-library.middleware");
if (is_string($middleware)) $middleware = [$middleware];
Route::scopeBindings()
    ->middleware(array_merge(
        ["auth:" . config("file-library.guard")],
        $middleware,
    ))
    ->group(function () {
        Route::resource("file/lib", FileController::class)
            ->names("file-library")
            ->parameters(["lib" => "file"])
            ->except(config("file-library.route_except", []));
    });