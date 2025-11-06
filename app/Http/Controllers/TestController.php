<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestResult;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TestController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // Constructor
    }

    public function index()
    {
        $regularTests = Test::where('is_final_exam', false)->orderBy('order')->get();
        $finalExam = Test::where('is_final_exam', true)->first();
        $user = auth()->user();

        return view('tests.index', compact('regularTests', 'finalExam', 'user'));
    }

    public function show(Test $test)
    {
        $userResults = TestResult::where('user_id', Auth::id())
            ->where('test_id', $test->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('tests.show', compact('test', 'userResults'));
    }

    public function start(Test $test)
    {
        if (!Auth::user()->canTakeTest($test)) {
            return back()->with('error', 'Вы не можете начать этот тест. Проверьте требования.');
        }

        $questions = $test->questions()->inRandomOrder()->get();
        
        return view('tests.take', compact('test', 'questions'));
    }

    public function submit(Request $request, Test $test)
    {
        Log::info('TestController@submit invoked', ['user_id' => Auth::id(), 'test_id' => $test->id]);

        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|exists:answers,id'
        ]);

        $score = 0;
        $totalQuestions = $test->questions->count();
        $wrongAnswers = [];

        foreach ($validated['answers'] as $questionId => $answerId) {
            $question = Question::find($questionId);
            if ($question->correct_answer_id == $answerId) {
                $score++;
            } else {
                $wrongAnswers[] = [
                    'question' => $question->content,
                    'your_answer' => $question->answers->find($answerId)->content,
                    'correct_answer' => $question->answers->find($question->correct_answer_id)->content,
                    'explanation' => $question->explanation
                ];
            }
        }

        $maxScore = $test->getMaxScore();
        $percentageScore = $maxScore > 0 ? ($score / $maxScore) * 100 : 0;
        $passed = $percentageScore >= $test->passing_score;

        // time_taken, started_at, completed_at are required by the schema; we don't track precise start time here,
        // so set started_at/completed_at to now and time_taken to 0 as a safe default.
        $now = now();

        $result = TestResult::create([
            'user_id' => Auth::id(),
            'test_id' => $test->id,
            'score' => $score,
            'max_score' => $maxScore,
            'passed' => $passed,
            'time_taken' => 0,
            'started_at' => $now,
            'completed_at' => $now,
        ]);

        Log::info('TestResult created', [
            'result_id' => $result->id ?? null,
            'user_id' => Auth::id(),
            'test_id' => $test->id,
            'score' => $score,
            'max_score' => $maxScore,
        ]);

        return redirect()->route('test-results.show', $result)
            ->with('status', $passed ? 'Тест успешно пройден!' : 'Тест не пройден. Ознакомьтесь с объяснениями.');
    }

    public function create()
    {
        $this->authorize('create', Test::class);
        return view('tests.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Test::class);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'passing_score' => 'required|integer|min:0|max:100',
            'order' => 'required|integer|min:0',
            'duration' => 'required|integer|min:1',
            'required_tests' => 'nullable|array',
            'required_tests.*' => 'exists:tests,id'
        ]);

        $test = Test::create($validated);
        
        if (isset($validated['required_tests'])) {
            $test->requiredTests()->sync($validated['required_tests']);
        }

        return redirect()->route('tests.index')
            ->with('status', 'Тест успешно создан');
    }

    public function edit(Test $test)
    {
        $this->authorize('update', $test);
        return view('tests.edit', compact('test'));
    }

    public function update(Request $request, Test $test)
    {
        $this->authorize('update', $test);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'passing_score' => 'required|integer|min:0|max:100',
            'order' => 'required|integer|min:0',
            'duration' => 'required|integer|min:1',
            'required_tests' => 'nullable|array',
            'required_tests.*' => 'exists:tests,id'
        ]);

        $test->update($validated);
        
        if (isset($validated['required_tests'])) {
            $test->requiredTests()->sync($validated['required_tests']);
        }

        return redirect()->route('tests.show', $test)
            ->with('status', 'Тест успешно обновлен');
    }

    public function destroy(Test $test)
    {
        $this->authorize('delete', $test);
        $test->delete();

        return redirect()->route('tests.index')
            ->with('status', 'Тест успешно удален');
    }
}
