<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageOptimizationService
{

    public function optimizeImage($path, $fullPath)
    {
            \Tinify\setKey(env('YOUR_TINYPNG_API_KEY'));

            $source = \Tinify\fromFile($fullPath);
            $resized = $source->resize([
                "method" => "cover",
                "width" => 70,
                "height" => 70
            ]);
    
            $croppedFilename = pathinfo($path, PATHINFO_FILENAME) . '_thumb.jpg';
            $croppedDir = storage_path('app/public/uploads/thumbs');
            $croppedPath = $croppedDir . '/' . $croppedFilename;
            if (!file_exists($croppedDir)) {
                mkdir($croppedDir, 0755, true);
            }
            $resized->toFile($croppedPath);
            $thumbUrl = Storage::url('uploads/thumbs/' . $croppedFilename);
            return $thumbUrl;
        
    }
}
