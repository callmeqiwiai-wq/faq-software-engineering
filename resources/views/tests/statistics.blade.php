@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Статистика тестирования</h1>

    <!-- Секция прогресса -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Ваш прогресс</h2>
        </div>
        <div class="mb-4">
            <p class="text-gray-600 mb-2">
                Пройдено {{ $completedTests }} из {{ $totalRegularTests }} тестов
            </p>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-blue-500 rounded-full h-4" style="width: {{ ($completedTests / $totalRegularTests) * 100 }}%"></div>
            </div>
            <p class="text-sm text-gray-500 mt-1">Прогресс обучения</p>
        </div>
    </div>

    <!-- Секция поздравления (если все тесты пройдены) -->
    @if($completedTests === $totalRegularTests && !$finalExamPassed)
    <div class="bg-white rounded-lg shadow-md p-8 mb-8 text-center">
        <div class="mb-4">
            <svg class="w-16 h-16 mx-auto text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12zm3-6a3 3 0 11-6 0 3 3 0 016 0z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold mb-2">Поздравляем!</h2>
        <p class="text-gray-600 mb-6">Вы прошли все тесты. Готовы к экзамену?</p>
        <a href="{{ route('test.start', $finalExam) }}" 
           class="inline-flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition duration-150">
            <span class="mr-2">Пройти экзамен</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
    @endif

    <!-- Список тестов -->
    <div class="space-y-4">
        @foreach($tests as $test)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 flex items-center justify-center rounded-full {{ $test->userLastResult && $test->userLastResult->passed ? 'bg-green-100' : 'bg-gray-100' }}">
                            @if($test->userLastResult && $test->userLastResult->passed)
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 110-12 6 6 0 010 12z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">{{ $test->title }}</h3>
                            @if($test->userLastResult)
                                <p class="text-sm text-gray-500">
                                    Последний результат: {{ $test->userLastResult->score }}/{{ $test->userLastResult->total_questions }}
                                    ({{ number_format($test->userLastResult->percentage, 1) }}%)
                                </p>
                            @endif
                        </div>
                    </div>
                    <div>
                        @if($test->userLastResult && $test->userLastResult->passed)
                            <a href="{{ route('test.start', $test) }}" 
                               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition duration-150">
                                Пройти снова
                            </a>
                        @else
                            <a href="{{ route('test.start', $test) }}" 
                               class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-150">
                                Начать
                            </a>
                        @endif
                    </div>
                </div>

                @if($test->required_tests->isNotEmpty())
                    <div class="mt-4 pl-16">
                        <p class="text-sm text-gray-600 mb-2">Требования:</p>
                        <ul class="space-y-1">
                            @foreach($test->required_tests as $requiredTest)
                                <li class="flex items-center">
                                    <span class="w-4 h-4 mr-2">
                                        @if($requiredTest->userLastResult && $requiredTest->userLastResult->passed)
                                            <svg class="text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </span>
                                    <span class="text-gray-600">{{ $requiredTest->title }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection