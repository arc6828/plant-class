<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlantIdentificationController extends Controller
{
    //
    public function showUploadForm()
    {
        return view('plant-identification');
    }

    public function identifyPlant(Request $request)
    {
        $request->validate([
            'plantImage' => 'required|image|max:16384',
        ]);
        // // resize image if needed using Intervention Image or similar library
        // $image = Image::make($request->file('plantImage'));
        // $image->resize(800, 800, function ($constraint) {
        //     $constraint->aspectRatio();
        // });
        // $image->save($imagePath);

        // เก็บไฟล์ภาพชั่วคราว
        $path = $request->file('plantImage')->store('temp', 'public');
        // $imagePath = asset('storage/' . $path);
        $imagePath = storage_path('app/public/' . $path);
        $imageBase64 = base64_encode(file_get_contents($imagePath));

        // Gemini API
        $response = Http::withHeaders([
            'x-goog-api-key' => '' . env('GEMINI_API_KEY'),
            'Content-Type'  => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/" . env('GEMINI_MODEL') . ":generateContent", [
            "contents" => [[
                "parts" => [
                    ["text" => "ระบุชื่อพืชชนิดนี้ พร้อมระบุชื่อวิทยาศาสตร์ + ชื่อสามัญเป็นภาษาไทยและภาษาอังกฤษ + description เป็นภาษาไทยอย่างเดียว ตอบเป็น JSON โดยมีโครงสร้าง {\"scientific_name\": \"\", \"common_name_th\": \"\", \"common_name_en\": \"\",\"description\": \"\"}"],
                    ["inline_data" => [
                        "mime_type" => "image/jpeg",
                        "data" => $imageBase64
                    ]]
                ]
            ]]
        ]);

        $result = "ไม่สามารถวิเคราะห์ได้";
        if ($response->successful()) {
            $data = $response->json();
            $result = $data['candidates'][0]['content']['parts'][0]['text'] ?? "ไม่พบข้อมูล";
        } else {
            $result = "Error: " . $response->status() . " - " . $response->body();
        }

        // echo "<h1>ผลการวิเคราะห์</h1>";
        // echo "<p>" . nl2br(e($result)) . "</p>";

        return back()->with('result', $result);
    }
}
