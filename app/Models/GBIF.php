<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class GBIF extends Model
{
    //
    public static $url_occurrence = "https://api.gbif.org/v1/occurrence/search";
    // https://api.gbif.org/v1/occurrence/search?country=TH&kingdomKey=6&limit=10

    public static function occurrence_search($opt=[]){

        // Fetch JSON data from external API (Replace with your actual URL)
        $options = [
            'country' => 'TH',
            'kingdomKey' => 6, // 6 means Plantae
            'limit' => '10',
            'offset' => '0',
        ];
        $options = array_merge($options,$opt);
        $response = Http::get(self::$url_occurrence, $options); // Use the correct API URL

        // Check if the request was successful
        if ($response->successful()) {
            $plants = $response->json(); // Decode JSON data to an array

            return $plants;
        } else {
            // Handle error in fetching data
            // $this->command->error("Failed to fetch data from the API.");
        }
    }
}
