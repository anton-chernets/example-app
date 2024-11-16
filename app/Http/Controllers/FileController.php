<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    /**
     * File downloading
     *
     * @param string $filename
     * @return never|StreamedResponse
     */
    public function download(string $filename)
    {
        $filePath = FileService::DIR_FILES . $filename;

        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        }

        return abort(404, 'File undefined');
    }

    /**
     * Files list.
     */
    public function list()
    {
        $files = Storage::files(FileService::DIR_FILES);
        $files = array_map(fn($file) => basename($file), $files);

        return response()->json($files);
    }
}
