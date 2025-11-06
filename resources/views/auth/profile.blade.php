@extends('layouts.app')

@section('title', 'Редактирование профиля')

@section('content')
<section class="edit-profile-section">
    <div class="edit-profile-content">
        <div class="edit-profile-container">
            <h1 class="profile-title">Редактирование профиля</h1>
            
            <form method="POST" action="{{ route('profile.update') }}" class="profile-editor">
                @csrf
                @method('PUT')
                
                <div class="profile-field">
                    <label class="profile-label">Имя</label>
                    <div class="name-box">
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                    </div>
                </div>

                <div class="profile-field">
                    <label class="profile-label">Фамилия</label>
                    <div class="surname-box">
                        <input type="text" name="surname" value="{{ old('surname', Auth::user()->surname) }}" required>
                    </div>
                </div>

                <div class="profile-field">
                    <label class="profile-label">Почта</label>
                    <div class="mail-box">
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                    </div>
                </div>

                <div class="profile-field">
                    <label class="profile-label">Текущий пароль</label>
                    <div class="pass-box">
                        <input type="password" name="current_password">
                    </div>
                </div>

                <div class="profile-field">
                    <label class="profile-label">Новый пароль</label>
                    <div class="pass-box">
                        <input type="password" name="password" id="password">
                    </div>
                    <div class="password-strength"></div>
                </div>

                <div class="profile-field">
                    <label class="profile-label">Подтверждение пароля</label>
                    <div class="pass-box">
                        <input type="password" name="password_confirmation">
                    </div>
                </div>

                <button type="submit" class="save-button">Сохранить изменения</button>
            </form>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const strengthDiv = document.querySelector('.password-strength');
    
    function checkPasswordStrength(password) {
        if (password.length === 0) return '';
        if (password.length < 6) return 'weak';
        if (password.length < 8) return 'medium';
        return 'strong';
    }
    
    passwordInput.addEventListener('input', function() {
        const strength = checkPasswordStrength(this.value);
        let message = '';
        let className = '';
        
        switch(strength) {
            case 'weak':
                message = 'Слабый пароль';
                className = 'strength-weak';
                break;
            case 'medium':
                message = 'Средний пароль';
                className = 'strength-medium';
                break;
            case 'strong':
                message = 'Сильный пароль';
                className = 'strength-strong';
                break;
        }
        
        strengthDiv.textContent = message;
        strengthDiv.className = 'password-strength ' + className;
    });
});
</script>
@endsection