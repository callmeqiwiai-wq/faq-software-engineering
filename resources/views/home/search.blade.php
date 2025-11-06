@extends('layouts.app')

@section('title', 'Результаты поиска')

@section('content')
<section class="search-results-section">
    <div class="search-results-content">
        <div class="search-results-container">
            <div class="search-results-header">
                <h1>Результаты поиска</h1>
                <p>По запросу "{{ $query }}" найдено {{ $articles->total() }} {{ trans_choice('результат|результата|результатов', $articles->total()) }}</p>
            </div>

            <div class="search-form">
                <form action="{{ route('search') }}" method="GET" class="search-box">
                    <input type="text" name="q" class="search-input" placeholder="Поиск по базе знаний..." value="{{ $query }}">
                    <button type="submit" class="search-button">
                        <img src="{{ asset('image/search.svg') }}" alt="Search">
                    </button>
                </form>
            </div>

            <div class="search-results-list">
                @forelse($articles as $article)
                    <div class="search-result-item">
                        <h3><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></h3>
                        <p class="search-result-section">{{ $article->section->title }}</p>
                        <p class="search-result-excerpt">
                            {{ Str::limit(strip_tags($article->content), 200) }}
                        </p>
                    </div>
                @empty
                    <div class="no-results">
                        <p>По вашему запросу ничего не найдено.</p>
                        <p>Попробуйте изменить поисковый запрос или перейти в <a href="{{ route('knowledge.index') }}">базу знаний</a>.</p>
                    </div>
                @endforelse
            </div>

            {{ $articles->links() }}
        </div>
    </div>
</section>
@endsection