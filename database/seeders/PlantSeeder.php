<?php

namespace Database\Seeders;

use App\Models\Plant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch JSON data from external API (Replace with your actual URL)
        $url = "https://raw.githubusercontent.com/arc6828/plant-py/refs/heads/main/plantnet/data/SEA-species.json";
        $response = Http::get($url); // Use the correct API URL

        // Check if the request was successful
        if ($response->successful()) {
            $plants = $response->json(); // Decode JSON data to an array

            // Loop through each plant data and insert into the database
            foreach ($plants as $plant) {
                Plant::create([
                    'species_name' => $plant['species-name'],
                    'slug' => $plant['slug'],
                    'common_name' => $plant['common-name'],
                    'common_name_th' => $plant['common-name-th'],
                    'genus' => $plant['genus'],
                    'family' => $plant['family'],
                    'images' => json_decode(str_replace("'",'"',$plant["images"])), // Store images as JSON
                    'num_images' => $plant['num-images'],
                    'num_observations' => $plant['num-observations'],
                ]);
            }
        } else {
            // Handle error in fetching data
            $this->command->error("Failed to fetch data from the API.");
        }
    }
}
