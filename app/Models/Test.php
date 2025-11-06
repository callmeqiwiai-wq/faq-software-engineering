<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'section_id',
        'is_final_exam',
        'passing_score',
        'duration',
        'order'
    ];

    protected $casts = [
        'is_final_exam' => 'boolean'
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function results(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }

    public function getMaxScore(): int
    {
        return $this->questions->sum('points');
    }

    public function requiredTests()
    {
        return $this->belongsToMany(Test::class, 'test_prerequisites', 'test_id', 'required_test_id');
    }

    // Backwards-compatible alias for snake_case usages in views/controllers/seeders
    public function required_tests()
    {
        return $this->requiredTests();
    }

    public function isFinalExam(): bool
    {
        return $this->is_final_exam;
    }

    public function isAvailableForUser(User $user): bool
    {
        // Если это не итоговый экзамен, проверяем только предварительные тесты
        if (!$this->isFinalExam()) {
            return $user->canTakeTest($this);
        }

        // Для итогового экзамена проверяем, что все предыдущие тесты пройдены успешно
        $regularTests = Test::where('is_final_exam', false)
            ->orderBy('order')
            ->get();

        foreach ($regularTests as $test) {
            if (!$user->hasPassedTest($test)) {
                return false;
            }
        }

        return true;
    }
}