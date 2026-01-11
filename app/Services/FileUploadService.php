<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    /**
     * Upload the given file to the specified disk and folder.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string $disk
     * @return string path to stored file
     */
    public function upload(UploadedFile $file, string $folder = 'uploads', string $disk = 'public'): string
    {
        $path = 'bousla/' . trim($folder, '/');

        return $file->store($path, $disk);
    }

    /**
     * Delete a file from storage.
     *
     * @param string $path
     * @param string $disk
     * @return bool
     */
    public function delete(string $path, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->delete($path);
    }

}
