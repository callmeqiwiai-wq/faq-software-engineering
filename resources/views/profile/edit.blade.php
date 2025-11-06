@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
<section class="edit-profile-section">
    <div class="edit-profile-content">
        <div class="edit-profile-container">
            <div class="profile-header">
                <h1 class="profile-title">Редактирование профиля</h1>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="profile-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Имя</label>
                    <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="surname">Фамилия</label>
                    <input type="text" id="surname" name="surname" value="{{ old('surname', auth()->user()->surname) }}" required>
                    @error('surname')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="current_password">Текущий пароль</label>
                    <input type="password" id="current_password" name="current_password">
                    @error('current_password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Новый пароль</label>
                    <input type="password" id="password" name="password">
                    <span class="input-note"></span>
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Подтверждение пароля</label>
                    <input type="password" id="password_confirmation" name="password_confirmation">
                </div>

                <button type="submit" class="save-changes-btn">Сохранить изменения</button>
            </form>

            <div class="test-results-section">
                <h2>История тестирования</h2>
                @if($testResults->count() > 0)
                    <div class="test-results-list">
                        @foreach($testResults as $result)
                            <div class="test-result-item">
                                <div class="test-info">
                                    <h3>{{ $result->test->title }}</h3>
                                    <span class="test-date">{{ $result->created_at->format('d.m.Y H:i') }}</span>
                                </div>
                                <div class="result-info">
                                    <span class="score">{{ $result->percentage }}%</span>
                                    <span class="status {{ $result->passed ? 'passed' : 'failed' }}">
                                        {{ $result->passed ? 'Пройден' : 'Не пройден' }}
                                    </span>
                                </div>
                                <a href="{{ route('test-results.show', $result) }}" class="view-details">Подробнее</a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>У вас пока нет пройденных тестов.</p>
                @endif
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    
    function checkPasswordStrength(password) {
        if (password.length === 0) return '';
        if (password.length < 6) return 'weak';
        if (password.length < 8) return 'medium';
        return 'strong';
    }
    
    passwordInput.addEventListener('input', function() {
        const strength = checkPasswordStrength(this.value);
        const note = this.nextElementSibling;
        
        note.className = 'input-note ' + strength;
        if (strength === 'weak') {
            note.textContent = 'Слабый пароль';
        } else if (strength === 'medium') {
            note.textContent = 'Средний пароль';
        } else if (strength === 'strong') {
            note.textContent = 'Надежный пароль';
        } else {
            note.textContent = '';
        }
    });
});
</script>
@endpush
@endsection