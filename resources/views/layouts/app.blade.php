<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SEG') }} - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
</head>
<body>
    <div class="sidebar">
        <div class="logo-details">
            <div class="logo-image">
                <img src="{{ asset('image/logotype.svg') }}" class="logo-icon-side">
                <span class="logo-text">SEG</span>
            </div>
        </div>
        <ul class="nav-links">
            <li class="{{ Request::is('/') ? 'active-menu-button' : '' }}">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('image/Home.svg') }}" class='home-icon-side'>
                    <span class="link_name">Главная</span>
                </a>
            </li>
            <li class="{{ Request::is('faq*') ? 'active-menu-button' : '' }}">
                <a href="{{ route('faq.index') }}">
                    <img src="{{ asset('image/Book open.svg') }}" class='book-icon-svg'>
                    <span class="link_name">База знаний</span>
                </a>
            </li>
            <li class="{{ Request::is('tests*') ? 'active-menu-button' : '' }}">
                <a href="{{ route('tests.index') }}">
                    <img src="{{ asset('image/Bar chart.svg') }}" class='bar-icon-side'>
                    <span class="link_name">Тесты</span>
                </a>
            </li>
            <li class="{{ Request::is('profile*') ? 'active-menu-button' : '' }}">
                <a href="{{ route('profile') }}">
                    <img src="{{ asset('image/User.svg') }}" class='user-icon-side'>
                    <span class="link_name">Профиль</span>
                </a>
            </li>
        </ul>
        <ul class="nav-links">
            <li>
                @auth
                    <div class="profile-details">
                        <div class="profile-content">
                            <img src="{{ asset('image/profile.svg') }}" class="profile-icon-side">
                        </div>
                        <div class="name-job">
                            <a href="{{ route('profile') }}" class="profile_name">{{ Auth::user()->name }}</a>
                            <a href="{{ route('profile') }}" class="job">Профиль</a>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" style="background: none; border: none; cursor: pointer;">
                                <img src="{{ asset('image/Logout.svg') }}" class='logout-icon-side'>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="profile-details">
                        <div class="profile-content">
                            <img src="{{ asset('image/profile.svg') }}" class="profile-icon-side">
                        </div>
                        <div class="name-job">
                            <a href="{{ route('login') }}" class="profile_name">Войти</a>
                            <a href="{{ route('register') }}" class="job">Регистрация</a>
                        </div>
                    </div>
                @endauth
            </li>
        </ul>
    </div>

    @yield('content')

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('scripts')
    {{-- allow views to push scripts with @push('scripts') --}}
    @stack('scripts')
</body>
</html>