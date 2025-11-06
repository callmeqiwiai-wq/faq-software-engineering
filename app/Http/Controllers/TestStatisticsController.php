<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestStatisticsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $tests = Test::where('is_final_exam', false)
            ->orderBy('order')
            ->with(['required_tests', 'results' => function($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->latest();
            }])
            ->get();

        $finalExam = Test::where('is_final_exam', true)->first();
        
        $completedTests = $tests->filter(function($test) {
            return $test->results->first()?->passed;
        })->count();

        $totalRegularTests = $tests->count();
        
        $finalExamPassed = $finalExam && TestResult::where('user_id', $user->id)
            ->where('test_id', $finalExam->id)
            ->where('passed', true)
            ->exists();

        return view('tests.statistics', compact(
            'tests',
            'finalExam',
            'completedTests',
            'totalRegularTests',
            'finalExamPassed'
        ));
    }
}