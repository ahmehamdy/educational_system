<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('course')->get();

        return response()->json([
            'status' => 200,
            'data' => $quizzes,
            'message' => 'All quizzes fetched successfully'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.option_1' => 'required|string',
            'questions.*.option_2' => 'required|string',
            'questions.*.option_3' => 'required|string',
            'questions.*.option_4' => 'required|string',
            'questions.*.correct_option' => 'required|in:option_1,option_2,option_3,option_4',
        ]);
        DB::beginTransaction();
        try {

            $course = Course::findOrFail($request->course_id);
            if ($course->instructor_id !== Auth::user()->instructor->id) {
                return response()->json(['message' => 'You are not allowed to add quizzes to this course'], 403);
            }

            $quiz = Quiz::create($request->only(['title', 'course_id', 'start_time', 'end_time']));

            foreach ($request->questions as $q) {
                $quiz->questions()->create([
                    'question_text' => $q['question_text'],
                    'option_1' => $q['option_1'],
                    'option_2' => $q['option_2'],
                    'option_3' => $q['option_3'],
                    'option_4' => $q['option_4'],
                    'correct_option' => $q['correct_option'],
                ]);
            }


            DB::commit();

            return response()->json([
                'status' => 201,
                'data' => $quiz->load('questions'),
                'message' => 'Quiz and questions created successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);

        if ($quiz->start_time && now()->lt($quiz->start_time)) {
            return response()->json([
                'status' => 403,
                'message' => "The quiz hasn't started yet. It starts on:" . $quiz->start_time->format('Y-m-d H:i:s'),
            ]);
        }

        if ($quiz->end_time && now()->gt($quiz->end_time)) {
            return response()->json([
                'status' => 403,
                'message' => 'Quiz time is over.',
            ]);
        }

        $user_type = Auth::user()->type ?? null;

        if (!in_array($user_type, ['admin', 'instructor'])) {
            $quiz->questions->transform(function ($question) {
                unset($question->correct_option);
                return $question;
            });
        }

        return response()->json([
            'status' => 200,
            'data' => $quiz,
            'message' => 'Quiz details fetched'
        ]);
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);
        $request->validate([
            'title' => 'sometimes|string',
            'description' => 'nullable|string',
            'course_id' => 'sometimes|exists:courses,id',
        ]);

        $quiz->update($request->only(['title', 'description', 'course_id']));

        return response()->json([
            'status' => 200,
            'data' => $quiz,
            'message' => 'Quiz updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Quiz deleted successfully'
        ]);
    }
}
