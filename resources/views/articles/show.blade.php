@extends('layouts.app')

@section('title', $article->title)

@section('content')
<section class="knowledge-section">
    <div class="knowledge-content">
        <div class="knowledge-container">
            <div class="knowledge-header">
                <h1 class="knowledge-title">{{ $article->title }}</h1>
                <div class="breadcrumb">
                    <a href="{{ route('knowledge.index') }}">База знаний</a>
                    <span>/</span>
                    <a href="{{ route('sections.show', $article->section) }}">{{ $article->section->title }}</a>
                </div>
            </div>
            
            <div class="article-content">
                {!! $article->content !!}
            </div>
            
            <div class="comments-section">
                <h3>Комментарии</h3>
                @auth
                    <form action="{{ route('comments.store', $article) }}" method="POST" class="comment-form">
                        @csrf
                        <textarea name="content" rows="3" placeholder="Оставьте комментарий..." required></textarea>
                        <button type="submit">Отправить</button>
                    </form>
                @else
                    <p class="login-to-comment">
                        <a href="{{ route('login') }}">Войдите</a> или 
                        <a href="{{ route('register') }}">зарегистрируйтесь</a> 
                        чтобы оставить комментарий
                    </p>
                @endauth

                <div class="comments-list">
                    @foreach($article->comments as $comment)
                        <div class="comment">
                            <div class="comment-header">
                                <span class="comment-author">{{ $comment->user->name }}</span>
                                <span class="comment-date">{{ $comment->created_at->format('d.m.Y H:i') }}</span>
                                
                                @if(auth()->check() && (auth()->user()->id === $comment->user_id || auth()->user()->hasRole(['admin', 'moderator'])))
                                    <div class="comment-actions">
                                        @if(auth()->user()->id === $comment->user_id)
                                            <button class="edit-comment" data-id="{{ $comment->id }}">Редактировать</button>
                                        @endif
                                        
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-comment">Удалить</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="comment-content" id="comment-content-{{ $comment->id }}">
                                {{ $comment->content }}
                            </div>
                            
                            <form action="{{ route('comments.update', $comment) }}" method="POST" class="edit-comment-form" id="edit-form-{{ $comment->id }}" style="display: none;">
                                @csrf
                                @method('PUT')
                                <textarea name="content" rows="3" required>{{ $comment->content }}</textarea>
                                <div class="form-actions">
                                    <button type="submit">Сохранить</button>
                                    <button type="button" class="cancel-edit" data-id="{{ $comment->id }}">Отмена</button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Редактирование комментария
    document.querySelectorAll('.edit-comment').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.id;
            const content = document.getElementById(`comment-content-${commentId}`);
            const form = document.getElementById(`edit-form-${commentId}`);
            
            content.style.display = 'none';
            form.style.display = 'block';
        });
    });

    // Отмена редактирования
    document.querySelectorAll('.cancel-edit').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.id;
            const content = document.getElementById(`comment-content-${commentId}`);
            const form = document.getElementById(`edit-form-${commentId}`);
            
            content.style.display = 'block';
            form.style.display = 'none';
        });
    });
});
</script>
@endpush
@endsection