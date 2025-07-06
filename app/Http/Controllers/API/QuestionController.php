<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('quiz')->get();

        return response()->json([
            'status' => 200,
            'data' => $questions,
            'message' => 'All questions fetched successfully'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_option' => 'required|in:a,b,c,d'
        ]);

        $question = Question::create($request->all());

        return response()->json([
            'status' => 201,
            'data' => $question,
            'message' => 'Question created successfully'
        ]);
    }

    public function show($id)
    {
        $question = Question::with('quiz')->findOrFail($id);

        return response()->json([
            'status' => 200,
            'data' => $question,
            'message' => 'Question details fetched successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $request->validate([
            'question_text' => 'sometimes|required|string',
            'option_a' => 'sometimes|required|string',
            'option_b' => 'sometimes|required|string',
            'option_c' => 'sometimes|required|string',
            'option_d' => 'sometimes|required|string',
            'correct_option' => 'sometimes|required|in:a,b,c,d',
        ]);

        $question->update($request->all());

        return response()->json([
            'status' => 200,
            'data' => $question,
            'message' => 'Question updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Question deleted successfully'
        ]);
    }
}
