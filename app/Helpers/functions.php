<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

if (!function_exists('apiResponse')) {
    /**
     * @param $success
     * @param $message
     * @param null $data
     * @return json
     */
    function apiResponse($success, $message, $statusCode, $data = null)
    {
        $response =  [
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }
}


if (!function_exists('uploadImage')) {
    /**
     * upload image in specific directory "storage"
     * @param $upload
     * @param $path
     * @param null $resize_width
     * @param null $resize_height
     * @return string
     */
    function uploadImage($file, $path, $resize_width = null, $resize_height = null): string
    {
        $checkPath = 'app/public/' . $path;
        if (!file_exists(storage_path($checkPath))) {
            mkdir(storage_path($checkPath), 777, true);
        }
        $fileName   = time() . $file->getClientOriginalName();
        Storage::disk('public')->put($path . '/' . $fileName, File::get($file));
        return $fileName;
    }
}

if (!function_exists('deleteImage')) {
    /**
     * delete image
     * @param $path
     * @return int
     */
    function deleteImage($file, $folder): int
    {
        $fullPath = $folder . '/' . $file;

        if (Storage::disk('public')->exists($fullPath)) {
            Storage::disk('public')->delete($fullPath);
        } else {
            return (7);
        }
        return true;
    }
}
