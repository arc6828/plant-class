<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
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
     * @param string $path
     * @param int $width
     * @param int $height
     * @param int $quality
     * @return string $path
     */
    public function processAndSave(
        string $path,
        int $width = 512,
        int $height = 512,
    ): String {
        $manager = new ImageManager(new Driver());
        $imagePath = storage_path('app/public/' . $path);
        $image = $manager->read($imagePath);
        $image = $image->resizeCanvas($width,  $height, '000000');
        //save to storage
        $image->save($imagePath);
        return $path;
    }
}

