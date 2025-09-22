<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use Illuminate\Http\Request;

class PlantIdentificationController extends Controller
{
    
    public function showUploadForm()
    {
        return view('plant-identification');
    }    

    // return string
    public function identifyPlant(Request $request, GeminiService $geminiService)
    {
        $request->validate([
            'plantImage' => 'required|image|max:16384',
        ]);

        // เก็บไฟล์ภาพชั่วคราว
        $path = $request->file('plantImage')->store('temp', 'public');
        // $imagePath = asset('storage/' . $path);
        $imagePath = storage_path('app/public/' . $path);

        $result = $geminiService->classifyImage($imagePath);       

        return back()->with('result', $result)->with('imagePath', $path);
    }
}
