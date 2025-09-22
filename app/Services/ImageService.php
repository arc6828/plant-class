<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;


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
     * @return UploadedFile $newfile
     */
    public function processAndSave(
        UploadedFile $file,
        int $width = 512,
        int $height = 512,
        int $quality = 80
    ): UploadedFile {
        // เปิดไฟล์ด้วย Intervention Image
        $image = Image::make($file)
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', $quality);

        return new UploadedFile(
            $image->stream()->getMetadata('uri'), // ใช้ stream URI แทน path
            $file->getClientOriginalName(),
            'image/jpeg',
            null,
            true // ตั้งค่าเป็น true เพื่อระบุว่าไฟล์นี้ถูกอัปโหลดแล้ว
        );


        // // กำหนดชื่อไฟล์ใหม่
        // $filename = Str::uuid() . '.jpg';

        // // กำหนด path ใน storage
        // $path = 'temp/' . $filename;

        // // บันทึกไฟล์ลง public disk
        // Storage::disk('public')->put($path, (string) $image);

        // // คืนค่าผลลัพธ์
        // return [
        //     'path'   => $path,
        //     'url'    => asset('storage/' . $path),
        //     'base64' => base64_encode((string) $image),
        // ];
    }
}
