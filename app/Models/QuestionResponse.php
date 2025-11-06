<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_result_id',
        'question_id',
        'response_text',
        'selected_answers',
        'is_correct',
        'points_earned'
    ];

    protected $casts = [
        'selected_answers' => 'array',
        'is_correct' => 'boolean'
    ];

    public function testResult(): BelongsTo
    {
        return $this->belongsTo(TestResult::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}