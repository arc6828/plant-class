<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function index(Request $request)
    {
        $query = Plant::query();

        // Search by keyword (scientific/common/common_th)
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('scientific_name', 'like', "%{$request->q}%")
                    ->orWhere('common_name', 'like', "%{$request->q}%")
                    ->orWhere('common_name_th', 'like', "%{$request->q}%");
            });
        }

        // Filter by family
        if ($request->filled('family')) {
            $query->where('family', $request->family);
        }

        $plants = $query->orderBy('scientific_name')->paginate(12)->withQueryString();

        // For filter dropdown
        $families = Plant::select('family')->distinct()->pluck('family')->filter();

        return view('db-plants.index', compact('plants', 'families'));
    }

    public function show(Plant $plant)
    {
        // if $plant->descrition is null, '
        if (is_null($plant->description)) {
            // create content from Gemini API

            $plant->description = 'No description available.';
        }
        return view('db-plants.show', compact('plant'));
    }
}
