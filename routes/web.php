<?php

use App\Http\Controllers\PlantClassificationController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PlantOccurrenceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('home');
});

Route::get('/welcome', function () {
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

require __DIR__ . '/auth.php';


// Route::get('/identify', [PlantClassificationController::class, 'showUploadForm'])->name('upload.form');
Route::get('/upload', [PlantClassificationController::class, 'showUploadForm'])->name('upload.form');
Route::post('/classify', [PlantClassificationController::class, 'classifyPlant'])->name('classify.plant');

Route::view('/identify', 'plant-identification');

Route::post('/plant-identification', function (Request $request) {
    $request->validate([
        'plantImage' => 'required|image|max:4096',
    ]);

    // เก็บไฟล์ภาพชั่วคราว
    $path = $request->file('plantImage')->store('temp', 'public');
    $imagePath = storage_path('app/public/' . $path);
    $imageBase64 = base64_encode(file_get_contents($imagePath));

    // Gemini API
    $response = Http::withHeaders([
        'x-goog-api-key' => '' . env('GEMINI_API_KEY'),
        'Content-Type'  => 'application/json',
    ])->post("https://generativelanguage.googleapis.com/v1beta/models/" . env('GEMINI_MODEL') . ":generateContent", [
        "contents" => [[
            "parts" => [
                ["text" => "ระบุชื่อพืชชนิดนี้ พร้อมระบุชื่อวิทยาศาสตร์ + ชื่อสามัญเป็นภาษาไทยและภาษาอังกฤษ + description เป็นภาษาไทยอย่างเดียว ตอบเป็น JSON โดยมีโครงสร้าง {\"scientific_name\": \"\", \"common_name_th\": \"\", \"common_name_en\": \"\"}"],
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
    }else{
        $result = "Error: " . $response->status() . " - " . $response->body();
    }

    // echo "<h1>ผลการวิเคราะห์</h1>";
    // echo "<p>" . nl2br(e($result)) . "</p>";

    return back()->with('result', $result);
})->name('plant.identify');

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


Route::get('/occurrence', function () {
    return Inertia::render('PlantOccurrence');
})->name('occurrence');

Route::get('/quickstart', function () {
    return view("quickstart");
})->name('quickstart');


Route::get('/plants', [PlantController::class, 'index'])->name('plants.index');
Route::get('/plants/{plant}', [PlantController::class, 'show'])->name('plants.show');

