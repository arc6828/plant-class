<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

// use Intervention\Image\Laravel\Facades\Image;


class ImageService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * จัดการอัปโหลดและประมวลผลภาพ
     *
     * @param UploadedFile $file
     * @param int $width
     * @param int $height
     * @param int $quality
     * @return string $path
     */
    public function processAndSave(
        UploadedFile $file,
        int $width = 512,
        int $height = 512,
        int $quality = 80
    ): String {
        $image = ImageManager::imagick()->read($file->getPathname());
        $image = $image->resizeCanvas($width,  $height, '000000');
        //save to storage
        $filename = Str::uuid() . '.jpg';
        // save progressive jpeg file in low quality
        $image->save(storage_path('app/public/temp/' . $filename), quality: 80, progressive: true);
        return 'temp/' . $filename;
    }
}

