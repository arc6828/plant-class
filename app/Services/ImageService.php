<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
// use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

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
     * @return array
     */
    public function processAndSave(
        UploadedFile $file,
        int $width = 512,
        int $height = 512,
        int $quality = 80
    ): array {
        // เปิดไฟล์ด้วย Intervention Image
        $image = Image::make($file)
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', $quality);

        // กำหนดชื่อไฟล์ใหม่
        $filename = Str::uuid() . '.jpg';

        // กำหนด path ใน storage
        $path = 'plants/' . $filename;

        // บันทึกไฟล์ลง public disk
        Storage::disk('public')->put($path, (string) $image);

        // คืนค่าผลลัพธ์
        return [
            'path'   => $path,
            'url'    => asset('storage/' . $path),
            'base64' => base64_encode((string) $image),
        ];
    }
}
