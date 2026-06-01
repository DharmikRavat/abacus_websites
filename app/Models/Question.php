<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';
        /**
     * Mass assignable fields
     */
    protected $fillable = [
        'question',
        'question_type_id',
        'options',
        'correct_option',
        'exam_level',
        'difficulty',
    ];

    /**
     * Cast JSON fields
     */
    protected $casts = [
        'options' => 'array',
    ];

    /**
     * Optional helper to check correct answer
     */
    public function isCorrect($answer)
    {
        return $this->correct_option === $answer;
    }

    public function questionType()
{
    return $this->belongsTo(
        \App\Models\QuestionType::class,
        'question_type_id'
    );
}


}
