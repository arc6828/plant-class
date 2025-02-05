<?php

// use App\Http\Controllers\LineBotController;
use App\Http\Controllers\PlantClassificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route("upload.form");
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/upload', [PlantClassificationController::class, 'showUploadForm'])->name('upload.form');
Route::post('/classify', [PlantClassificationController::class, 'classifyPlant'])->name('classify.plant');


Route::resource('/plants', PlantClassificationController::class);