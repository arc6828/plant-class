<?php

use App\Http\Controllers\Api\DeployController;
use App\Http\Controllers\Api\DictionaryController;
use App\Http\Controllers\LineBotController;
use App\Models\Dictionary;
use App\Models\GBIF;
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

Route::prefix('gbif')->group(function () {
    Route::prefix('plants')->group(function () {
        Route::get('occurrence', function (Request $request) {
            // Retrieve the first 5 records from the plant_data table
            $opt = $request->all();
            $plants = GBIF::occurrence_search($opt);

            // Return the plants as a JSON response
            return response()->json($plants);
            // return $plants;
        });
    });
});

Route::get('/dict', [DictionaryController::class,'mapKeyValue']);
Route::apiResource('/dictionary',DictionaryController::class);
Route::apiResource('/deploy', DeployController::class);


