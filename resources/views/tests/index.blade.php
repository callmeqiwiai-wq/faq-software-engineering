@extends('layouts.app')

@section('content')
<section class="tests-section">
    <div class="test-content">
        <div class="test-container">
            <div class="test-header" style="display:flex;align-items:center;justify-content:space-between;gap:12px">
                <h1 class="test-topic-title">Доступные тесты</h1>
                @can('create', App\Models\Test::class)
                    <a href="{{ route('tests.create') }}" class="start-button">Создать тест</a>
                @endcan
            </div>

            <div class="tests-list">
                @foreach($regularTests as $test)
                    <div class="test-item {{ $user->canTakeTest($test) ? 'passed' : 'locked' }}">
                        <div class="test-header">
                            <h3 class="test-title">{{ $test->title }}</h3>
                            <p class="test-status">{{ $test->description }}</p>
                        </div>

                        @if($test->required_tests->isNotEmpty())
                            <div style="margin-top:10px">
                                <strong class="block" style="margin-bottom:8px">Требования:</strong>
                                <ul>
                                    @foreach($test->required_tests as $requiredTest)
                                        <li style="display:flex;align-items:center;gap:8px;margin-bottom:6px">
                                            @if($user->testResults()->where('test_id', $requiredTest->id)->where('passed', true)->exists())
                                                <span style="width:14px;height:14px;background:#dafbe6;border-radius:50%;display:inline-block"></span>
                                            @else
                                                <span style="width:14px;height:14px;background:#ffd6d6;border-radius:50%;display:inline-block"></span>
                                            @endif
                                            <span class="text-muted">{{ $requiredTest->title }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div style="margin-top:12px">
                            @if($user->canTakeTest($test))
                                <a href="{{ route('test.start', $test) }}" class="start-button">Начать тест</a>
                            @else
                                <button class="retry-button" disabled>Сначала пройдите обязательные тесты</button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($finalExam)
                <div style="max-width:900px;margin:24px auto 0">
                    <div class="test-item">
                        <div style="background:#159df3;padding:14px;border-radius:8px;color:#fff;margin:-24px -24px 16px -24px">
                            <h2 class="test-topic-title" style="color:#fff">Финальный экзамен</h2>
                        </div>
                        <h3 class="test-title">{{ $finalExam->title }}</h3>
                        <p class="test-status">{{ $finalExam->description }}</p>
                        <div style="margin-top:12px">
                            @if($user->canTakeTest($finalExam))
                                <a href="{{ route('test.start', $finalExam) }}" class="start-button">Начать финальный экзамен</a>
                            @else
                                <button class="retry-button" disabled>Сначала пройдите все обязательные тесты</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection