<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function store(Request $request)
    {
        $result = (new FileService())->uploadFileByChunks(
            $request->input('fileName'),
            $request->input('chunkIndex'),
            $request->input('totalChunks'),
            $request->file('file')
        );

        return response()->json(['status' => $result]);
    }
}
