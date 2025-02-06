<?php

use App\Http\Controllers\PlantClassificationController;
use App\Http\Controllers\PlantOccurrenceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


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


Route::get('/occurrence',function(){
    return Inertia::render('PlantOccurrence');
})->name('occurrence');