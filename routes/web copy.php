<?php

// use App\Http\Controllers\LineBotController;
use App\Http\Controllers\PlantClassificationController;
use App\Http\Controllers\PlantOccurrenceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route("upload.form");
});



Route::get('/upload', [PlantClassificationController::class, 'showUploadForm'])->name('upload.form');
Route::post('/classify', [PlantClassificationController::class, 'classifyPlant'])->name('classify.plant');


// Route::resource('/plants', PlantClassificationController::class);
// Route::resource('/plants', PlantClassificationController::class);

Route::prefix('plantnet')->group(function () {
    Route::get('plants', [PlantClassificationController::class, 'index'])->name('plantnet.plants.index');
});

Route::prefix('gbif')->group(function () {
    Route::prefix('plants')->group(function () {
        Route::resource('occurrence', PlantOccurrenceController::class);        
    });
});
