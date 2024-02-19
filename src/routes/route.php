<?php

use ikepu_tp\FileLibrary\app\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

$middleware = config("file-library.middleware");
if (is_string($middleware)) $middleware = [$middleware];
Route::group([
    "middleware" => array_merge(
        ["guard:" . config("file-library.guard")],
        $middleware,
    ),
], function () {
    Route::resource("file/lib", FileController::class)->names("file-library");
});