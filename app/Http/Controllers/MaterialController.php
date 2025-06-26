<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::all();
        return view('theem.pages.oldMaterial', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('theem.pages.createoldMaterial');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200|min:5',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:10240'
        ]);

        try {
            $files = [];
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                        . '.' . $file->getClientOriginalExtension();
                    #يتبع
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }

        Material::create([
            'material_name' => $validated['title'],

        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
