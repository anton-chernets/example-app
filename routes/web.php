<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;

Route::get('/', function () {
    return view('welcome');
});

// Files
Route::resource('upload', UploadController::class)->only(['index', 'store']);
Route::get('/uploaded-files', [FileController::class, 'list']);
Route::get('/download/{filename}', [FileController::class, 'download'])
    ->where('filename', '.*')//Allows use dots and slashes in the file name
    ->name('file.download');
