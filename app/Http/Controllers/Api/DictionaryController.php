<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dictionary;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    /**
     * get Dictionary as Key - Value for very fast retrieve value by key
     */
    public function mapKeyValue()
    {
        $dict = Dictionary::pluck('output', 'input');
        return response()->json($dict);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dict = Dictionary::all();
        return response()->json($dict);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation
        $data = $request->validate([
            'input' => 'required',
            'output' => 'required',
            'tags' => 'required',
        ]);

        // บันทึกลงฐานข้อมูล
        $dict = Dictionary::firstOrCreate(
            ['input' => $data['input']],
            [
                'output' => $data['output'],
                'tags' => $data['tags'],
            ]
        );

        return response()->json($dict);
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
