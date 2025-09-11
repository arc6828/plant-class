<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl;
    protected $baseModel;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->baseUrl = "https://generativelanguage.googleapis.com/v1beta/models";
        $this->baseModel = env('GEMINI_MODEL');
    }

    /**
     * ส่งข้อความไปยัง Gemini API
     */
    public function generateText(string $prompt, $model = null)
    {

        $model = $model ?? $this->baseModel;

        $response = Http::withHeaders([
            'x-goog-api-key' => '' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/{$model}:generateContent", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
        ]);

        $result = "ไม่มีข้อมูลตอบกลับ";
        if ($response->successful()) {
            $data = $response->json();
            $result = $data['candidates'][0]['content']['parts'][0]['text'] ?? "ไม่พบข้อมูล";
        } else {
            $result = "Error: " . $response->status() . " - " . $response->body();
        }

        return $result;
    }

    /**
     * อัปโหลดและวิเคราะห์ภาพด้วย Gemini
     */
    public function classifyImage(string $imagePath, string $prompt = 'Identify this plant')
    {
        $imageData = base64_encode(file_get_contents($imagePath));

        $response = Http::withHeaders([
            'x-goog-api-key' => '' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/{$this->baseModel}:generateContent", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                        [
                            'inline_data' => [
                                'mime_type' => 'image/jpeg',
                                'data' => $imageData
                            ]
                        ]
                    ]
                ]
            ],
        ]);

        $result = "ไม่สามารถวิเคราะห์ได้";
        if ($response->successful()) {
            $data = $response->json();
            $result = $data['candidates'][0]['content']['parts'][0]['text'] ?? "ไม่พบข้อมูล";
        } else {
            $result = "Error: " . $response->status() . " - " . $response->body();
        }

        return $result;
    }
}
