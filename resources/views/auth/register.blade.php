@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<section class="reg-section">
    <div class="reg-content">
        <div class="profile-header">
            <h1 class="profile-title">Регистрация</h1>
        </div>
        <div class="reg-container">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <span class="reg-text">Имя</span>
                <div class="name-box">
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Введите ваше имя">
                </div>

                <span class="reg-text">Фамилия</span>
                <div class="surname-box">
                    <input type="text" name="surname" value="{{ old('surname') }}" required placeholder="Введите вашу фамилию">
                </div>

                <span class="reg-text">Почта</span>
                <div class="mail-box">
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="Введите вашу почту">
                </div>

                <span class="reg-text">Пароль</span>
                <div class="pass-box">
                    <input type="password" name="password" required placeholder="Придумайте пароль">
                </div>

                <span class="reg-text">Подтверждение пароля</span>
                <div class="pass-box">
                    <input type="password" name="password_confirmation" required placeholder="Повторите пароль">
                </div>

                <button type="submit" class="reg-button">Зарегистрироваться</button>
            </form>
        </div>
    </div>
</section>
@endsection