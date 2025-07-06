<?php

namespace App\Http\Controllers\API;

use App\Models\Material;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::latest()->paginate(10);
        if ($materials->isEmpty()) {
            $response = [
                'status' => 200,
                'message' => "Data is Empty"
            ];
        } else {
            $response = [
                'status' => 200,
                'data' => $materials,
                'message' => 'Get Data Successfully'

            ];
        }

        return response($response, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:200|min:5',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,mp4,mov,avi,mkv,webm|max:102400',
            'status' => 'required|string|in:new,old',
            'course_id' => 'required|exists:courses,id',

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
                'status' => $validated['status'],
                'course_id' => $validated['course_id'],
            ]);
            $response = [
                'status' => 200,
                'data' => $materials,
                'message' => 'store Material Successfully'

            ];
            return response($response, 200);
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
        $material = Material::find($id);
        if (!$material) {
            $response = [
                'status' => 404,
                'message' => 'this material isnot Found'
            ];
        } else {
            $response = [
                'status' => 200,
                'data' => $material,
                'message' => 'show material successfuly'
            ];
        }
        return response($response, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $material = Material::find($id);
        if (!$material) {
            return response([
                'status' => 404,
                'message' => 'This material is not in data'
            ]);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:200|min:5',
            'status' => 'sometimes|required|string|in:new,old',
            'file' => 'sometimes|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,mp4,mov,avi,mkv,webm|max:10240',
            'course_id' => 'sometimes|required|exists:courses,id',

        ]);

        // تحديث البيانات النصية
        $material->fill($validated);

        // لو الملف موجود، حدثه
        if ($request->hasFile('file')) {
            // حذف الملف القديم من التخزين
            if ($material->material_link && Storage::disk('public')->exists($material->material_link)) {
                Storage::disk('public')->delete($material->material_link);
            }


            $file = $request->file('file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('material_attachment', $filename, 'public');

            $material->material_name = $file->getClientOriginalName();
            $material->material_type = $file->getClientMimeType();
            $material->material_link = $path;
        }

        $material->save();

        return response([
            'status' => 200,
            'data' => $material,
            'message' => 'Update material successfully'
        ]);
    }

    public function download($id)
    {
        $material = Material::find($id);
        $link = $material->material_link;
        $path = public_path("storage/$link");

        return response()->download($path);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material = Material::find($id);
        if (!$material) {
            return response()->json(['success' => false, 'message' => 'Material not found'], 404);
        }

        // Delete the stored file
        Storage::disk('public')->delete($material->material_link);

        $material->delete();

        return response()->json(['success' => true, 'message' => 'Material deleted successfully']);
    }
}
