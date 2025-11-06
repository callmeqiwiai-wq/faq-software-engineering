@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">История тестирования</h1>
            <p class="text-gray-600">Ваши результаты по всем пройденным тестам</p>
        </div>

        @if($results->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Тест
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Дата
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Результат
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Статус
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Действия
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($results as $result)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $result->test->title }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">
                                        {{ $result->created_at->format('d.m.Y H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $result->score }}/{{ $result->total_questions }}
                                        ({{ $result->percentage }}%)
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $result->passed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $result->passed ? 'Пройден' : 'Не пройден' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('test-results.show', $result) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        Подробнее
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $results->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-600">У вас пока нет пройденных тестов.</p>
                <a href="{{ route('tests.index') }}" 
                   class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                    Перейти к тестам
                </a>
            </div>
        @endif
    </div>
</div>
@endsection