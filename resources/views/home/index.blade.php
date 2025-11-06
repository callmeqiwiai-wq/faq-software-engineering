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
                    <button type="submit" class="search-button">
                        <img src="{{ asset('image/search.svg') }}" alt="Search">
                    </button>
                </form>
            </div>

            <div class="topics-grid">
                @foreach($sections as $section)
                    <a href="{{ route('sections.show', $section) }}" class="topic-card">
                        <img src="{{ asset('image/topics/' . $section->icon) }}" alt="{{ $section->title }}">
                        <span class="topic-text">{{ $section->title }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection