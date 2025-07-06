<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizSubmission;
use App\Models\QuestionAnswer;
use Illuminate\Http\Request;

class QuizSubmissionController extends Controller
{
    public function submit(Request $request, $quizId)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'answers.*' => 'nullable|in:option_1,option_2,option_3,option_4',
        ]);

        $quiz = Quiz::with('questions')->findOrFail($quizId);
        $correctAnswers = 0;

        $submission = QuizSubmission::create([
            'student_id' => $request->student_id,
            'quiz_id' => $quiz->id,
            'score' => 0,
        ]);

        foreach ($quiz->questions as $question) {
            $selected = $request->answers[$question->id] ?? null;
            if ($selected && in_array($selected, ['option_1', 'option_2', 'option_3', 'option_4'])) {
                $isCorrect = $selected === $question->correct_option;
            } else {
                $isCorrect = false;
            }

            QuestionAnswer::create([
                'submission_id' => $submission->id,
                'question_id' => $question->id,
                'selected_option' => $selected,
                'is_correct' => $isCorrect,
            ]);

            if ($isCorrect) {
                $correctAnswers++;
            }
        }

        $submission->update(['score' => $correctAnswers]);

        return response()->json([
            'status' => 200,
            'message' => 'Quiz submitted successfully',
            'score' => $correctAnswers,
            'submission_id' => $submission->id
        ]);
    }

    // عرض نتيجة الطالب بعد الحل
    public function show($submissionId)
    {
        $submission = QuizSubmission::with([
            'quiz',
            'answers.question',
            'student.user' // لو حابب تعرض بيانات الطالب
        ])->findOrFail($submissionId);

        return response()->json([
            'status' => 200,
            'data' => $submission,
            'message' => 'Submission details fetched successfully'
        ]);
    }
}
