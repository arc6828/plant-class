<?php

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

Route::get('/dict', function () {
    $dict = Dictionary::pluck('output', 'input');
    return response()->json($dict);
});
Route::get('/dictionary', function () {
    $dict = Dictionary::all();
    return response()->json($dict);
});
Route::post('/dictionary', function (Request $request) {
    // validation
    $data = $request->validate([
        'input' => 'required',
        'output' => 'required',
        // 'tags' => 'required',
    ]);

    // บันทึกลงฐานข้อมูล
    $dict = Dictionary::firstOrCreate(
        ['input' => $data['input']],
        [
            'output' => $data['output'],
            // 'tags' => $data['tags'],
        ]
    );

    return response()->json($dict);
});

Route::get('/deploy', function (Request $request) {
    try {
        
        exec('/bin/bash /var/www/plants.samkhok.org/deploy.sh >> /var/log/deploy.log 2>&1 &',$output, $return_var);
        
        $data = [
            "status" => "success", 
            "messsage" => "Deployment triggered",
            "console" => $output,
        ];

        return response()->json($data);
    } catch (Exception $e) {
        $data = [
            "status" => "fail", 
            "messsage" => $e->getMessage(),
        ];
        return response()->json($data);
    }
});

Route::post('/deploy', function (Request $request) {
    try {
        $secret = "thisisabook"; // Optional if you set a webhook secret
        $signature = $_SERVER['HTTP_X_HUB_SIGNATURE'] ?? '';

        // Verify signature
        // if ($secret && !hash_equals('sha1=' . hash_hmac('sha1', file_get_contents('php://input'), $secret), $signature)) {
        //     http_response_code(403);
        //     exit('Invalid signature');
        // }

        // Run the deploy script
        // $output = shell_exec('/bin/bash /var/www/plants.samkhok.org/deploy.sh >> /var/log/deploy.log 2>&1 &');
        exec('/bin/bash /var/www/plants.samkhok.org/deploy.sh >> /var/log/deploy.log 2>&1 &',$output, $return_var);

        // if ($return_var === 0) {
        //     echo "Command executed successfully.\n";
        //     print_r($output); // Print the output of the ls command
        // } else {
        //     echo "Command failed with exit code: " . $return_var . "\n";
        // }
        // echo "Deployment triggered";
        $data = [
            "status" => "success", 
            "messsage" => "Deployment triggered",
            "console" => $output,
        ];

        // return response()->json($data);
    } catch (Exception $e) {
        $data = [
            "status" => "fail", 
            "messsage" => $e->getMessage(),
        ];
        return response()->json($data);
    }
});
