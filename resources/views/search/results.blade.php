@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold mb-2">Поиск</h1>
            <form action="{{ route('search') }}" method="GET" class="flex gap-4">
                <input type="text" 
                       name="query" 
                       value="{{ $query }}"
                       placeholder="Введите поисковый запрос..."
                       class="flex-1 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm p-2"
                       required>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                    Искать
                </button>
            </form>
        </div>

        @if($query)
            <div class="space-y-8">
                @if($sections->isNotEmpty())
                    <div>
                        <h2 class="text-xl font-semibold mb-4">Разделы</h2>
                        <div class="space-y-4">
                            @foreach($sections as $section)
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h3 class="font-semibold mb-2">
                                        <a href="{{ route('sections.show', $section) }}" 
                                           class="text-blue-600 hover:text-blue-800">
                                            {{ $section->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600">{{ Str::limit($section->description, 200) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($articles->isNotEmpty())
                    <div>
                        <h2 class="text-xl font-semibold mb-4">Статьи</h2>
                        <div class="space-y-4">
                            @foreach($articles as $article)
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h3 class="font-semibold mb-2">
                                        <a href="{{ route('articles.show', $article) }}" 
                                           class="text-blue-600 hover:text-blue-800">
                                            {{ $article->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600">{{ Str::limit($article->content, 200) }}</p>
                                    <div class="mt-2 text-sm text-gray-500">
                                        Раздел: 
                                        <a href="{{ route('sections.show', $article->section) }}" 
                                           class="text-blue-600 hover:text-blue-800">
                                            {{ $article->section->title }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($tests->isNotEmpty())
                    <div>
                        <h2 class="text-xl font-semibold mb-4">Тесты</h2>
                        <div class="space-y-4">
                            @foreach($tests as $test)
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h3 class="font-semibold mb-2">
                                        <a href="{{ route('tests.show', $test) }}" 
                                           class="text-blue-600 hover:text-blue-800">
                                            {{ $test->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600">{{ Str::limit($test->description, 200) }}</p>
                                    <div class="mt-2 flex items-center gap-4 text-sm text-gray-500">
                                        <span>Проходной балл: {{ $test->passing_score }}%</span>
                                        <span>Длительность: {{ $test->duration }} мин.</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($sections->isEmpty() && $articles->isEmpty() && $tests->isEmpty())
                    <div class="text-center py-8 text-gray-600">
                        По вашему запросу ничего не найдено. Попробуйте изменить поисковый запрос.
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection