@extends('layouts.app')

@section('content')
<section class="test-section">
    <div class="test-content">
        <div class="test-container">
            <div class="test-header">
                <h1 class="test-topic-title">{{ $test->title }}</h1>
                <p class="text-muted">Оставшееся время: <span id="timer" class="font-semibold"></span></p>
            </div>

            <div class="test-main">
                <form action="{{ route('tests.submit', $test) }}" method="POST" id="testForm">
                    @csrf

                    @foreach($questions as $index => $question)
                        <div class="question-section">
                            <h3 class="question-title">Вопрос {{ $index + 1 }} из {{ $questions->count() }}</h3>
                            <p class="question-text">{{ $question->content }}</p>

                            <div class="options-list">
                                @foreach($question->answers as $answer)
                                    <label class="option-item">
                                        <input type="radio" name="answers[{{ $question->id }}]" id="answer{{ $answer->id }}" value="{{ $answer->id }}" class="option-input" required>
                                        <span class="custom-radio"></span>
                                        <span class="option-text">{{ $answer->content }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="test-navigation-buttons" style="margin-top:18px">
                        <button type="submit" class="save-button">Завершить тест</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var duration = @json($test->duration * 60); // Convert minutes to seconds
        var timeLeft = duration;
        
        function updateTimer() {
            var minutes = Math.floor(timeLeft / 60);
            var seconds = timeLeft % 60;
            var timerElement = document.getElementById('timer');
            if (timerElement) {
                timerElement.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
            }
            
            if (timeLeft === 0) {
                var form = document.getElementById('testForm');
                if (form) {
                    form.submit();
                }
            } else {
                timeLeft--;
                setTimeout(updateTimer, 1000);
            }
        }
        
        updateTimer();
    });
</script>
@endpush
@endsection