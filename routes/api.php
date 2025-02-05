<?php

use App\Http\Controllers\LineBotController;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/webhook/line', [LineBotController::class, 'webhook']);


Route::get('/plants', function () {
    // Retrieve the first 5 records from the plant_data table
    $plants = Plant::limit(5)->get();

    // Return the plants as a JSON response
    return response()->json($plants);
    // return $plants;
});