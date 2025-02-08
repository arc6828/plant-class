<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class DeployController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
