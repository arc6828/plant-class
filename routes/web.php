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
        'plantImage' => 'required|image|max:16384',
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
                ["text" => "ระบุชื่อพืชชนิดนี้ พร้อมระบุชื่อวิทยาศาสตร์ + ชื่อสามัญเป็นภาษาไทยและภาษาอังกฤษ + description เป็นภาษาไทยอย่างเดียว ตอบเป็น JSON โดยมีโครงสร้าง {\"scientific_name\": \"\", \"common_name_th\": \"\", \"common_name_en\": \"\",\"description\": \"\"}"],
                ["image_url" => $imagePath ]
            ]
        ]]
    ]);

    $result = "ไม่สามารถวิเคราะห์ได้";
    if ($response->successful()) {
        $data = $response->json();
        $result = $data['candidates'][0]['content']['parts'][0]['text'] ?? "ไม่พบข้อมูล";
    } else {
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

Route::get('/about', function () {
    $researchers = [
        (object)["image" => "https://raw.githubusercontent.com/arc6828/samkhok/main/assets/img/researchers/wisrut.jpg", "name" => "ผศ.ดร.วิศรุต ขวัญคุ้ม", "position" => "หัวหน้าโครงการวิจัย", "organization" => "หลักสูตรวิทยาการคอมพิวเตอร์ คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏวไลยอลงกรณ์ ในพระบรมราชูปถัมภ์"],
        (object)["image" => "https://raw.githubusercontent.com/arc6828/samkhok/main/assets/img/researchers/ing_orn.jpg", "name" => "ผศ.อิงอร วงษ์ศรีรักษา", "position" => "ผู้ช่วยโครงการวิจัย", "organization" => "หลักสูตรเทคโนโลยีสารสนเทศ คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏวไลยอลงกรณ์ ในพระบรมราชูปถัมภ์"],
        (object)["image" => "https://raw.githubusercontent.com/arc6828/samkhok/main/assets/img/researchers/phairin.jpg", "name" => "ผศ.ไพรินทร์ มีศรี", "position" => "ผู้ช่วยโครงการวิจัย", "organization" => "หลักสูตรเทคโนโลยีสารสนเทศ คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏวไลยอลงกรณ์ ในพระบรมราชูปถัมภ์"],
        (object)["image" => "https://raw.githubusercontent.com/arc6828/samkhok/main/assets/img/researchers/kamolmas.jpg", "name" => "ผศ.กมลมาศ วงษ์ใหญ่", "position" => "ผู้ช่วยโครงการวิจัย", "organization" => "หลักสูตรเทคโนโลยีสารสนเทศ คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏวไลยอลงกรณ์ ในพระบรมราชูปถัมภ์"],
        (object)["image" => "https://raw.githubusercontent.com/arc6828/samkhok/main/assets/img/researchers/daorathar.jpg", "name" => "ดร.ดาวรถา วีระพันธ์", "position" => "ผู้ช่วยโครงการวิจัย", "organization" => "หลักสูตรวิทยาการคอมพิวเตอร์ คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏวไลยอลงกรณ์ ในพระบรมราชูปถัมภ์"],
        (object)["image" => "https://raw.githubusercontent.com/arc6828/samkhok/main/assets/img/researchers/natradee.jpg", "name" => "อ.ณัฐรดี อนุพงค์", "position" => "ผู้ช่วยโครงการวิจัย", "organization" => "หลักสูตรวิทยาการคอมพิวเตอร์ คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏวไลยอลงกรณ์ ในพระบรมราชูปถัมภ์"],
        (object)["image" => "https://raw.githubusercontent.com/arc6828/samkhok/main/assets/img/researchers/chavalit.jpg", "name" => "อ.ชวลิต โควีระวงศ์", "position" => "ผู้ช่วยโครงการวิจัย", "organization" => "หลักสูตรวิทยาการคอมพิวเตอร์ คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏวไลยอลงกรณ์ ในพระบรมราชูปถัมภ์"],
        (object)["image" => "https://raw.githubusercontent.com/arc6828/samkhok/main/assets/img/researchers/pannarat.jpg", "name" => "ผศ.ปัณณรัตน์ วงศ์พัฒนานิภาส", "position" => "ผู้ช่วยโครงการวิจัย", "organization" => "หลักสูตรนวัตกรรมดิจิทัลและวิศวกรรมซอฟต์แวร์ คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏวไลยอลงกรณ์ ในพระบรมราชูปถัมภ์"],
    ];
    return view('about', compact('researchers'));
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
// contact.send
Route::post('/contact', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string',
    ]);

    // Send email or store message in database
    return back()->with('success', 'ข้อความของคุณถูกส่งเรียบร้อยแล้ว');
})->name('contact.send');   
Route::get('/research-results', function () {
    return view('research-results');
})->name('research.results');