@extends('layouts.app')

@section('content')
<section class="test-detail-section">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h1 class="title">{{ $test->title }}</h1>
                    <p class="subtitle">{{ $test->description }}</p>
                </div>

                @if(Auth::user() && Auth::user()->isAdmin())
                    <div class="admin-actions">
                        <a href="{{ route('tests.edit', $test) }}" class="secondary-button">Редактировать</a>
                        <form action="{{ route('tests.destroy', $test) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот тест?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="danger-button">Удалить</button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="card-body">
                <h2 class="section-title">Информация о тесте</h2>

                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Длительность:</div>
                        <div class="info-value">{{ $test->duration }} минут</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Проходной балл:</div>
                        <div class="info-value">{{ $test->passing_score }}%</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Количество вопросов:</div>
                        <div class="info-value">{{ $test->questions->count() }}</div>
                    </div>
                </div>

                @if($test->required_tests->isNotEmpty())
                    <div class="requirements">
                        <h3>Требования</h3>
                        <p>Для прохождения этого теста необходимо успешно пройти следующие тесты:</p>
                        <ul class="requirements-list">
                            @foreach($test->required_tests as $requiredTest)
                                <li>{{ $requiredTest->title }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($userResults)
                    <div class="last-result">
                        <h3>Ваш последний результат</h3>
                        <div class="result-card">
                            <div class="result-row">
                                <div class="label">Дата прохождения:</div>
                                <div class="value">{{ $userResults->created_at->format('d.m.Y H:i') }}</div>
                            </div>
                            <div class="result-row">
                                <div class="label">Результат:</div>
                                <div class="value {{ $userResults->passed ? 'success' : 'failure' }}">
                                    {{ $userResults->score }} из {{ $userResults->total_questions }} ({{ $userResults->percentage }}%)
                                </div>
                            </div>
                            <a href="{{ route('test-results.show', $userResults) }}" class="link">Посмотреть детали</a>
                        </div>
                    </div>
                @endif

                <div class="card-actions">
                    <a href="{{ route('test.start', $test) }}" class="primary-button">Начать тест</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection