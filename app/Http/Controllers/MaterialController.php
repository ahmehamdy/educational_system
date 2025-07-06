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
        $materials = Material::latest()->paginate(10);
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
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:200|min:5',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:10240',
            'status' => 'required|string|in:new,old',
        ]);

        try {
            $file = $request->file('file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('material_attachment', $filename, 'public');
            $name = $file->getClientOriginalName();
            $type = $file->getClientMimeType();

            $user = auth()->user();

            $materials =  Material::create([
                'title' => $validated['title'],
                'material_name' => $name,
                'material_type' => $type,
                'material_link' => $path,
                'instructor_id' => $user->instructor->id,
                'status' => $validated['status']
            ]);
            // dd($request->all());
        return redirect()->route('materials.index')->with('success', 'Material uploaded successfully!');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
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
