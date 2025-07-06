<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'question_id',
        'selected_option',
        'is_correct',
    ];

    public function submission()
    {
        return $this->belongsTo(QuizSubmission::class, 'submission_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
