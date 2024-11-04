<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlantClassificationController extends Controller
{
    // Show the upload form
    public function showUploadForm()
    {
        return view('upload');
    }

    // Handle image upload and call PlantNet API for classification
    public function classifyPlant(Request $request)
    {
        // Validate the request
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Retrieve the uploaded image
        $image = $request->file('image');
        $imagePath = $image->getPathname();

        // Set your PlantNet API key
        $apiKey = env('PLANTNET_API_KEY');  // Store API key in .env file
        $apiUrl = "https://my-api.plantnet.org/v2/identify/all?api-key=$apiKey&include-related-images=true&nb-results=3";

        // Prepare image for the API request
        $response = Http::attach(
            'images',
            file_get_contents($imagePath),
            $image->getClientOriginalName()
        )->post($apiUrl, [
            'organs' => 'leaf', // You can modify this based on your needs (e.g., 'flower', 'fruit', etc.)
        ]);

        // Check if the API request was successful
        if ($response->successful()) {
            $result = $response->json();
            return view('result', ['result' => $result]);
        } else {
            return back()->with('error', 'Failed to classify the image. Please try again.');
        }
    }
}
