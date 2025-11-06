@extends('layouts.app')

@section('title', 'Авторизация')

@section('content')
<section class="login-section">
    <div class="login-content">
        <div class="profile-header">
            <h1 class="profile-title">Авторизация</h1>
        </div>
        <div class="login-container">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <span class="login-text">Почта</span>
                <div class="mail-box">
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Введите вашу почту">
                </div>

                <span class="login-text">Пароль</span>
                <div class="pass-box">
                    <input type="password" name="password" required placeholder="Введите ваш пароль">
                </div>

                <button type="submit" class="save-button">Войти</button>
            </form>
        </div>
    </div>
</section>
@endsection