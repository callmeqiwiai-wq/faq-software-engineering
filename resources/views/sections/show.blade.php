@extends('layouts.app')

@section('title', $section->title)

@section('content')
<section class="section-section">
    <div class="section-content">
        <div class="section-container">
            <div class="section-header">
                <h1>{{ $section->title }}</h1>
                <div class="breadcrumb">
                    <a href="{{ route('knowledge.index') }}">База знаний</a>
                    <span>/</span>
                    <span>{{ $section->title }}</span>
                </div>
            </div>

            <div class="section-description">
                {!! $section->description !!}
            </div>

            <div class="articles-list">
                @foreach($articles as $article)
                    <div class="article-card">
                        <h3><a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a></h3>
                        <p>{{ Str::limit(strip_tags($article->content), 200) }}</p>
                        <a href="{{ route('articles.show', $article->slug) }}" class="read-more">Читать далее</a>
                    </div>
                @endforeach
            </div>

            @if(auth()->check() && auth()->user()->isAdmin())
                <div class="admin-actions">
                    <a href="{{ route('sections.edit', $section) }}" class="edit-button">Редактировать раздел</a>
                    <form action="{{ route('sections.destroy', $section) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-button" onclick="return confirm('Вы уверены?')">Удалить раздел</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection