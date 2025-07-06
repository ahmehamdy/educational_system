<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->type !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized. Only admins can get all courses.'
            ], 403);
        }

        $courses = Course::with(['instructor.user', 'level', 'materials'])->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $courses
        ]);
    }

    public function show($id)
    {
        $course = Course::with(['instructor.user', 'level', 'materials'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $course
        ]);
    }

    public function myCourses()
    {
        $user =Auth::user();

        if (!$user->instructor) {
            return response()->json([
                'message' => 'You are not an instructor.'
            ], 403);
        }

        $courses = Course::with('level')
            ->where('instructor_id', $user->instructor->id)
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $courses,
            'message' => 'Instructor courses fetched successfully'
        ]);
    }


    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->type !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized. Only admins can create courses.'
            ], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level_id' => 'required|exists:levels,id',
            'instructor_id' => 'nullable|exists:instructors,id'
        ]);

        $course = Course::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'level_id' => $validated['level_id'],
            'instructor_id' => $validated['instructor_id'] ?? null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course created successfully',
            'data' => $course
        ]);
    }



    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'level_id' => 'sometimes|exists:levels,id',
            'instructor_id' => 'nullable|exists:instructors,id'
        ]);

        $course = Course::findOrFail($id);

        $course->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully',
            'data' => $course
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $course = Course::findOrFail($id);

        if ($user->type === 'admin') {
            $course->delete();
            return response()->json([
                'success' => true,
                'message' => 'Course deleted successfully by admin'
            ]);
        }
        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully'
        ]);
    }
}
