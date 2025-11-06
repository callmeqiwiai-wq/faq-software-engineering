@extends('layouts.app')

@section('title', 'База знаний')

@section('content')
<section class="faq-section">
    <div class="faq-content">
        <div class="faq-container">
            <h1 class="faq-title">База знаний</h1>
            <p class="faq-subtitle">Статьи по ключевым темам программной инженерии</p>
            
            <div class="topics-list">
                @foreach($sections as $section)
                    <div class="topic">
                        <div class="topic-header" onclick="toggleTopic('topic-{{ $section->id }}')">
                            <h3>{{ $section->title }}</h3>
                            <img src="{{ asset('image/dropdown-arrow.svg') }}" class="dropdown-arrow">
                        </div>
                        
                        <div class="topic-dropdown" id="topic-{{ $section->id }}">
                            @foreach($section->articles()->orderBy('order')->get() as $article)
                                <a href="{{ route('articles.show', $article->slug) }}" class="topic-link">
                                    {{ $article->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function toggleTopic(topicId) {
        const dropdown = document.getElementById(topicId);
        const header = dropdown.previousElementSibling;
        const arrow = header ? header.querySelector('.dropdown-arrow') : null;

        dropdown.classList.toggle('active');
        if (arrow) {
            arrow.classList.toggle('rotated');
        }
    }

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.topic-header')) {
            const dropdowns = document.querySelectorAll('.topic-dropdown.active');
            const arrows = document.querySelectorAll('.dropdown-arrow.rotated');
            
            dropdowns.forEach(dropdown => dropdown.classList.remove('active'));
            arrows.forEach(arrow => arrow.classList.remove('rotated'));
        }
    });
</script>
@endpush
@endsection