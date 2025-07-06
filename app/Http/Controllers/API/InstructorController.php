<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instructors = Instructor::with(['user', 'courses'])->get();

        $response = [
            'status' => 200,
            'data' => $instructors,
            'message' => 'Get All Instructors Successfully'
        ];

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $instructor = Instructor::with(['user', 'courses'])->where('id', $id)->first();

        if (!$instructor) {
            return response()->json([
                'status' => 404,
                'message' => 'Instructor not found'
            ], 404);
        }

        $response = [
            'status' => 200,
            'data' => $instructor,
            'message' => 'Get Instructor information Successfully'
        ];

        return response()->json($response);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
