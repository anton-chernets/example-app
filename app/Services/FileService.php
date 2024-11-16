<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    const DIR_TEMP = 'private/temp/';
    const DIR_FILES = 'uploads/';

    /**
     * @param string $fileName
     * @param mixed $chunkIndex
     * @param mixed $totalChunks
     * @param UploadedFile $chunk
     * @return bool
     */
    public function uploadFileByChunks(mixed $fileName, mixed $chunkIndex, mixed $totalChunks, UploadedFile $chunk): bool
    {
        $tempDir = self::DIR_TEMP . "{$fileName}/";

        if (!Storage::exists($tempDir)) {
            Storage::makeDirectory($tempDir);
        }

        $chunkPath = $tempDir . $chunkIndex;
        Storage::put($chunkPath, file_get_contents($chunk->getRealPath()));

        if ($chunkIndex == $totalChunks - 1) {
            $this->mergeChunksToFile($tempDir, $fileName);
        }

        return true;
    }

    /**
     * @param string $tempDir
     * @param string $fileName
     */
    private function mergeChunksToFile(string $tempDir, string $fileName): void
    {
        $finalPath = self::DIR_FILES . "{$fileName}";
        $chunkFiles = Storage::files($tempDir);

        sort($chunkFiles);

        Storage::put($finalPath, '');// Final file

        foreach ($chunkFiles as $chunk) {
            Storage::append($finalPath, Storage::get($chunk));
        }

        Storage::deleteDirectory($tempDir);
    }
}
