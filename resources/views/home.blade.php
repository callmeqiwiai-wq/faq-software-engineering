@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<section class="home-section">
    <div class="home-content">
        <div class="main-container">
            <div class="header-section">
                <img src="{{ asset('image/HomeLOGO.svg') }}" class="GreetingLogo">
                <h1 class="GreetingText">Справочник по программной<br> инженерии</h1>
            </div>
            
            <div class="search-container">
                <form action="{{ route('search') }}" method="GET" class="search-box">
                    <input type="text" name="q" class="search-input" placeholder="Поиск по базе знаний..." value="{{ request('q') }}">
                    <button type="submit" class="search-button">Найти</button>
                </form>
            </div>

            <div class="topics-grid">
                @foreach($sections as $section)
                    <a href="{{ route('sections.show', $section->slug) }}" class="topic-card">
                        <h3 class="topic-text">{{ $section->title }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection