@extends('layouts.app')

@section('content')
<section class="result-section">
    <div class="container">
        <div class="card">
            <header class="card-header">
                <h1 class="title">Результаты теста</h1>
                <p class="subtitle">{{ $result->test->title }}</p>
            </header>

            <div class="card-body">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-label">Общий результат:</div>
                        <div class="stat-value {{ $result->passed ? 'success' : 'failure' }}">{{ $result->percentage }}%</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Правильных ответов:</div>
                        <div class="stat-value">{{ $result->score }} из {{ $result->total_questions }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Статус:</div>
                        <div class="stat-value {{ $result->passed ? 'success' : 'failure' }}">{{ $result->passed ? 'Тест пройден' : 'Тест не пройден' }}</div>
                    </div>
                </div>

                @if(!$result->passed && !empty($result->wrong_answers))
                    <section class="errors-review">
                        <h2 class="section-title">Разбор ошибок</h2>

                        @foreach(json_decode($result->wrong_answers) as $index => $wrong)
                            <article class="error-card">
                                <h3 class="error-title">Вопрос {{ $index + 1 }}:</h3>
                                <p class="error-question">{{ $wrong->question }}</p>

                                <div class="error-block">
                                    <div class="label">Ваш ответ:</div>
                                    <p class="text">{{ $wrong->your_answer }}</p>
                                </div>

                                <div class="error-block">
                                    <div class="label">Правильный ответ:</div>
                                    <p class="text">{{ $wrong->correct_answer }}</p>
                                </div>

                                @if(isset($wrong->explanation))
                                    <div class="explanation">
                                        <strong>Объяснение:</strong>
                                        <p class="muted">{{ $wrong->explanation }}</p>
                                    </div>
                                @endif
                            </article>
                        @endforeach
                    </section>
                @endif

                <div class="card-actions">
                    <a href="{{ route('tests.index') }}" class="secondary-button">К списку тестов</a>
                    @if(!$result->passed)
                        <a href="{{ route('test.start', $result->test) }}" class="primary-button">Пройти тест заново</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection