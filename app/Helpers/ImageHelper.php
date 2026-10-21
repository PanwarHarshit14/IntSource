<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

function saveDataUriImage($dataUri, $folder = 'Uploads')
{
    if (empty($dataUri) || ! str_starts_with($dataUri, 'data:')) {
        return null;
    }

    try {
        if (! str_contains($dataUri, ';base64,')) {
            return null;
        }

        [, $data] = explode(';base64,', $dataUri);
        $data = base64_decode($data);

        if (! $data) {
            return null;
        }

        $mime = finfo_buffer(finfo_open(), $data, FILEINFO_MIME_TYPE);
        $ext = explode('/', $mime)[1] ?? 'png';

        $filename = uniqid().'.'.$ext;
        $path = "$folder/$filename";

        Storage::disk('public')->put($path, $data);

        return $path;
    } catch (Throwable $e) {
        Log::error('Image saving failed: '.$e->getMessage());

        return null;
    }
}
