<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use App\Services\ImageService;
use Illuminate\Http\Request;

class PlantIdentificationController extends Controller
{
    
    public function showUploadForm()
    {
        return view('plant-identification');
    }    

    // return string
    public function identifyPlant(Request $request, GeminiService $geminiService, ImageService $imageService)
    {
        $request->validate([
            'plantImage' => 'required|image|max:16384',
        ]);
        // $file = $request->file('plantImage');
        // Resize and save the image using ImageService
        $path = $imageService->processAndSave($request->file('plantImage'));
        // เก็บไฟล์ภาพชั่วคราว
        // $path = $file->store('temp', 'public');
        // $imagePath = asset('storage/' . $path);

        $result = $geminiService->classifyImage($path);       

        return back()->with('result', $result)->with('imagePath', $path);
    }
}
